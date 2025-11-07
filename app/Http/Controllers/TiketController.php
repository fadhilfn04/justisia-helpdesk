<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketFile;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TiketController extends Controller
{
    public function index()
    {
        $ticket = Ticket::all();
        $agents = User::whereHas('categoryAgent')->get();
        return view('pages.helpdesk.index', compact('ticket', 'agents'));
    }

    // public function index()
    // {
    //     $user = auth()->user();

    //     $query = Ticket::with(['user', 'agent'])->latest();

    //     if ($user->role->name === 'admin') {
    //         // Admin bisa lihat semua tiket
    //         $tickets = $query->get();
    //     } elseif ($user->role->name === 'agent') {
    //         // Agent hanya lihat tiket yang ditugaskan ke dia
    //         $tickets = $query->where('assigned_to', $user->id)->get();
    //     } else {
    //         // Pengguna hanya lihat tiket yang dia buat
    //         $tickets = $query->where('user_id', $user->id)->get();
    //     }

    //     // Daftar agent hanya untuk admin
    //     $agents = User::whereHas('categoryAgent')->get();

    //     return view('pages.helpdesk.index', compact('tickets', 'agents'));
    // }

    public function show($id)
    {
        $tiket = Ticket::with(['user', 'category'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tiket
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userPelaporId' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|exists:ticket_categories,id',
            'fileTiket.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $ticket = Ticket::create([
            'user_id' => $request->userPelaporId,
            'category_id' => $request->kategori,
            'assigned_to' => null,
            'wilayah_id' => null,
            'title' => $request->title,
            'description' => $request->deskripsi,
            'status' => $request->status,
        ]);

        if($request->status != 'draft')
        {
            Notification::create([
                'user_id' => $request->userPelaporId,
                'type' => 'success',
                'title' => 'Tiket berhasil dibuat',
                'message' => 'Tiket Anda telah berhasil dibuat. Mohon tunggu, admin akan segera melakukan verifikasi.'
            ]);
        }

        $fileUrls = [];

        if ($request->hasFile('fileTiket')) {
            foreach ($request->file('fileTiket') as $file) {
                $path = $file->store('fileTickets', 'public');
                $url = Storage::url($path);

                TicketFile::create([
                    'ticket_id' => $ticket->id,
                    'file_ticket' => $url,
                ]);

                $fileUrls[] = $url;
            }
        }

        return response()->json([
            'message' => 'Tiket berhasil disimpan',
            'ticket_id' => $ticket->id,
            'files' => $fileUrls,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tiketId' => 'required|exists:tickets,id',
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|exists:ticket_categories,id',
            'fileTiket.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $ticket = Ticket::findOrFail($request->tiketId);

        foreach ($ticket->file as $file) {
            $path = str_replace('/storage/', '', $file->file_ticket);
            Storage::disk('public')->delete($path);
            $file->delete();
        }

        $fileUrls = [];
        if ($request->hasFile('fileTiket')) {
            foreach ($request->file('fileTiket') as $file) {
                $path = $file->store('fileTickets', 'public');
                $url = Storage::url($path);

                TicketFile::create([
                    'ticket_id' => $ticket->id,
                    'file_ticket' => $url,
                ]);

                $fileUrls[] = $url;
            }
        }

        $ticket->update([
            'category_id' => $request->kategori,
            'title' => $request->title,
            'description' => $request->deskripsi,
        ]);

        return response()->json([
            'message' => 'Tiket berhasil diperbarui',
            'ticket_id' => $ticket->id,
            'files' => $fileUrls,
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::with('file')->findOrFail($request->id);

        foreach ($ticket->file as $file) {
            $path = str_replace('/storage/', '', $file->file_ticket);
            Storage::disk('public')->delete($path);
            $file->delete();
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Tiket dan file berhasil dihapus'
        ]);
    }

    public function verification($id, Request $request)
    {
        try {
            $tiket = Ticket::findOrFail($id);
            $tiket->assigned_to = $request->agent_id;
            $tiket->priority = $request->priority;
            $tiket->status = 'assignee';
            $tiket->save();

            NotificationService::send(
                $tiket->user_id,
                'Tiket Diverifikasi',
                "Tiket #{$tiket->id} telah diverifikasi dan sedang diproses."
            );

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil diverifikasi!',
                'data' => $tiket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi tiket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function return($id)
    {
        try {
            $tiket = Ticket::findOrFail($id);
            $tiket->status = 'need_revision';
            $tiket->save();

            NotificationService::send(
                $tiket->user_id,
                'Tiket Dikembalikan',
                "Tiket #{$tiket->id} telah dikembalikan dikarenakan informasi yang diterima kurang."
            );

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil direvisi!',
                'data' => $tiket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal merevisi tiket: ' . $e->getMessage()
            ], 500);
        }
    }
}
