<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TiketController extends Controller
{
    public function index()
    {
        $ticket = Ticket::all();
        return view('pages.helpdesk.index', compact('ticket'));
    }

    public function verification($id, Request $request)
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

}
