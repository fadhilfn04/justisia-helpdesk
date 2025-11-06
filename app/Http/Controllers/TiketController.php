<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

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

    public function create()
    {
        $categories = TicketCategory::all();
        return view('pages.helpdesk.create', compact('categories'));
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
