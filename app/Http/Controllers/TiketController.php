<?php

namespace App\Http\Controllers;

use App\Exports\TiketExport;
use App\Models\CategoryAgent;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketFile;
use App\Models\TicketMessage;
use App\Models\TicketTimeline;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function index()
    {
        $ticket = Ticket::all();
        $agents = CategoryAgent::with('user')->get();
        return view('pages.tiket.index', compact('ticket', 'agents'));
    }

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

        $normalizedTitle = strtolower(trim(preg_replace('/\s+/', ' ', $request->title)));
        $isDuplicate = Ticket::where('user_id', $request->userPelaporId)
            ->get()
            ->contains(function ($ticket) use ($normalizedTitle) {
                $dbTitle = strtolower(trim(preg_replace('/\s+/', ' ', $ticket->title)));
                return $dbTitle === $normalizedTitle;
            });

        if ($isDuplicate) {
            return response()->json([
                'message' => 'Tiket dengan judul yang sama telah tercatat sebelumnya.',
                'duplicate' => true
            ], 422);
        }

        $ticket = Ticket::create([
            'user_id' => $request->userPelaporId,
            'category_id' => $request->kategori,
            'assigned_to' => null,
            'wilayah_id' => null,
            'title' => $request->title,
            'description' => $request->deskripsi,
            'status' => $request->status,
        ]);

        $ticketTimeline = TicketTimeline::create([
            'ticket_id' => $ticket->id,
            'actor_id' => $request->userPelaporId,
            'action' => $request->status,
            'description' => 'Tiket baru: ' . $request->title . '',
        ]);

        if($request->status != 'draft')
        {
            NotificationService::send(
                $request->userPelaporId,
                'Tiket berhasil diajukan',
                "Tiket Anda dengan ID #{$ticket->id} telah berhasil diajukan. Mohon tunggu, admin akan segera melakukan verifikasi."
            );
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
        $ticket = Ticket::findOrFail($request->tiketId);

        if($request->isAjukan == 1 && ($ticket->status == "draft" || $ticket->status == "need_revision"))
        {
            $ticket->update([
                'status' => 'open',
            ]);

            $ticketTimeline = TicketTimeline::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $ticket->user_id,
                'action' => $ticket->status,
                'description' => 'Tiket telah diperbaharui: ' . $ticket->title . '',
            ]);

            NotificationService::send(
                $ticket->user_id,
                'Tiket berhasil diperbarui',
                "Tiket Anda dengan ID #{$ticket->id} telah berhasil diperbarui. Mohon tunggu, admin akan segera melakukan verifikasi."
            );

            return response()->json([
                'message' => 'Tiket berhasil diperbarui'
            ]);
        }

        $validated = $request->validate([
            'tiketId' => 'required|exists:tickets,id',
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|exists:ticket_categories,id',
            'fileTiket.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

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

        $ticketTimeline = TicketTimeline::create([
            'ticket_id' => $ticket->id,
            'actor_id' => $ticket->user_id,
            'action' => $ticket->status,
            'description' => 'Tiket telah dihapus: ' . $ticket->title . '',
        ]);

        NotificationService::send(
            $ticket->user_id,
            'Tiket Dihapus',
            "Tiket Anda dengan ID #{$ticket->id} telah berhasil dihapus."
        );

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
            $ticket = Ticket::findOrFail($id);

            $ticket->assigned_to = $request->agent_id;
            $ticket->priority = $request->priority;
            $ticket->status = 'assignee';
            $ticket->verified_at = now();

            $slaHours = match ($request->priority) {
                'high' => 24,
                'medium' => 48,
                'low' => 72,
                default => 48,
            };

            $ticket->sla_due_at = now()->addHours($slaHours);
            $ticket->save();

            TicketTimeline::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $ticket->user_id,
                'action' => $ticket->status,
                'description' => 'Tiket telah diverifikasi: ' . $ticket->title,
            ]);

            NotificationService::send(
                $ticket->user_id,
                'Tiket Diverifikasi',
                "Tiket Anda dengan ID #{$ticket->id} telah diverifikasi dan sedang diproses. Batas waktu penyelesaian: " .
                $ticket->sla_due_at->translatedFormat('d M Y H:i')
            );

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil diverifikasi!',
                'data' => $ticket
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
            $ticket = Ticket::findOrFail($id);
            $ticket->status = 'need_revision';
            $ticket->save();

            $ticketTimeline = TicketTimeline::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $ticket->user_id,
                'action' => $ticket->status,
                'description' => 'Tiket telah dikembalikan ke pengguna: ' . $ticket->title . '',
            ]);

            NotificationService::send(
                $ticket->user_id,
                'Tiket Dikembalikan',
                "Tiket Anda dengan ID #{$ticket->id} telah dikembalikan dikarenakan informasi yang diterima kurang."
            );

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil direvisi!',
                'data' => $ticket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal merevisi tiket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function close($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->status = 'closed';
            $ticket->save();

            $ticketTimeline = TicketTimeline::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $ticket->user_id,
                'action' => $ticket->status,
                'description' => 'Tiket telah ditutup: ' . $ticket->title . '',
            ]);

            NotificationService::send(
                $ticket->user_id,
                'Tiket Ditutup',
                "Tiket Anda dengan ID #{$ticket->id} telah ditutup dikarenakan permasalahan sudah selesai."
            );

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil ditutup!',
                'data' => $ticket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal merevisi tiket: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllChat($ticketId)
    {
        $messages = TicketMessage::with('sender')
            ->where('ticket_id', $ticketId)
            ->orderBy('id')
            ->get();

        return response()->json($messages);
    }

    public function sendChat(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|integer',
            'message'   => 'required|string',
        ]);

        $msg = TicketMessage::create([
            'ticket_id' => $request->ticket_id,
            'sender_id' => $request->sender_id,
            'message'   => $request->message
        ]);

        return response()->json($msg);
    }

    public function getTimeline($id)
    {
        $timelines = TicketTimeline::with('actor')
            ->where('ticket_id', $id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($t) {
                return [
                    'action' => $t->action,
                    'description' => $t->description,
                    'actor' => $t->actor ? ['name' => $t->actor->name] : null,
                    'created_at_human' => $t->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'timelines' => $timelines,
        ]);
    }

    public function actionTiketAgent(Request $request)
    {
        $tiket = Ticket::findOrFail($request->tiketId);
        if($request->isAction == "0")
        {
            $tiket->status = "agent_rejected";
            $tiket->assigned_to = null;
            $tiket->sla_due_at = null;

            NotificationService::send(
                $tiket->user_id,
                "Tiket #{$tiket->id} ditolak oleh agent",
                $request->message,
                "info",
            );

            $tiket->save();
        }

        if($request->isAction == "1")
        {
            $tiket->status = "in_progress";

            NotificationService::send(
                $tiket->user_id,
                'Tiket berhasil diterima agent',
                "Tiket #{$tiket->id} telah diterima oleh agen. Silakan klik icon respon pada tabel sesuai id tiket anda untuk memulai diskusi. Proses akan selesai setelah agen menginput penyelesaian tiket.",
                "info",
            );

            $tiket->save();
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function ticketResolution(Request $request)
    {
        $tiket = Ticket::findOrFail($request->id);

        $tiket->status = "closed";
        $tiket->ticket_resolution_message = $request->pesanPenyelesaian;

        if ($request->hasFile('fileTiketPenyelesaian')) {
            $file = $request->file('fileTiketPenyelesaian');

            $path = $file->store('ticket_resolution', 'public');
            $tiket->completion_ticket_file = $path;
        }

        NotificationService::send(
            $tiket->user_id,
            'Tiket berhasil diselesaikan oleh agent',
            "Tiket #{$tiket->id} telah diselesaikan oleh agen.",
            "success",
        );

        $tiket->save();

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil diselesaikan.',
        ]);
    }

    public function exportTiket(Request $request)
    {
        $query = Ticket::query();
        $userId = Auth::id();

        if (auth()->user()->role->id == '3') {
            $query->where('user_id', $userId);
        }

        if (auth()->user()->role->id == '2') {
            $isAgentTeknis = CategoryAgent::where('user_id', $userId)->get();
            $categories = $isAgentTeknis->pluck('category');

            $categoryTiketAgent = TicketCategory::whereIn('name', $categories)->get();
            $categoryIds = $categoryTiketAgent->pluck('id');

            $query->where('assigned_to', $userId)
                ->whereIn('status', ['assignee', 'in_progress', 'closed', 'solved'])
                ->whereIn('category_id', $categoryIds);
        }

        if (auth()->user()->role->id == '1') {
            $query->whereNotIn('status', ['draft', 'need_revision']);
        }

        if ($request->filled('dariTanggal') && $request->filled('sampaiTanggal')) {
            $dari = $request->dariTanggal . ' 00:00:00';
            $sampai = $request->sampaiTanggal . ' 23:59:59';
            $query->whereBetween('created_at', [$dari, $sampai]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioritas')) {
            $query->where('priority', $request->prioritas);
        }

        $tickets = $query
            ->with([
                'user:id,name,email',
                'agent:id,name,email',
                'category:id,name',
            ])
            ->latest()
            ->get();

        return response()->json([
            'data' => $tickets,
            'success' => true,
        ]);
    }
}
