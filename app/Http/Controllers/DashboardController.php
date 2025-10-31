<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Notification;
use App\Models\FeedbackSurvey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // === KARTU STATISTIK UTAMA ===
        $totalTickets = Ticket::count();
        $totalCancelledCertificates = Ticket::where('category_id', 2)->count(); // contoh kategori 2 = pembatalan sertifikat
        $totalDisputes = Ticket::where('category_id', 3)->count(); // contoh kategori 3 = kasus sengketa
        $resolutionRate = Ticket::where('status', 'closed')->count() > 0
            ? round((Ticket::where('status', 'closed')->count() / $totalTickets) * 100, 2)
            : 0;

        // === CHART: Tren Tiket Bulanan (12 bulan terakhir) ===
        $monthlyData = Ticket::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw("SUM(CASE WHEN status != 'Selesai' THEN 1 ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai")
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Buat array kategori & nilai per bulan
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $months = collect(range(1, 12));

        $monthlyTrends = [
            'categories' => $months->map(fn($m) => $monthNames[$m - 1]),
            'masuk' => $months->map(fn($m) =>
                $monthlyData->firstWhere('month', $m)->masuk ?? 0
            ),
            'selesai' => $months->map(fn($m) =>
                $monthlyData->firstWhere('month', $m)->selesai ?? 0
            ),
        ];

        // === CHART: Jenis Sengketa (by kategori) ===
        $disputeByCategory = Ticket::select('ticket_categories.name', DB::raw('COUNT(tickets.id) as total'))
            ->join('ticket_categories', 'tickets.category_id', '=', 'ticket_categories.id')
            ->groupBy('ticket_categories.name')
            ->get();

        // === TABEL: Tiket Terbaru ===
        $latestTickets = Ticket::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        // === KARTU: Distribusi Regional (contoh grouping berdasarkan user phone prefix atau dummy) ===
        $regionalDistribution = User::select(DB::raw('LEFT(phone, 4) as region'), DB::raw('COUNT(*) as total'))
            ->groupBy('region')
            ->get();

        // === REAL-TIME: Status Tiket (jumlah per status) ===
        $ticketStatusStats = Ticket::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // === REAL-TIME: Aktivitas Timeline ===
        $recentActivities = DB::table('ticket_timelines')
            ->join('tickets', 'ticket_timelines.ticket_id', '=', 'tickets.id')
            ->join('users', 'ticket_timelines.actor_id', '=', 'users.id')
            ->select('ticket_timelines.*', 'tickets.title as ticket_title', 'users.name as actor_name')
            ->orderByDesc('ticket_timelines.created_at')
            ->limit(5)
            ->get();

        // === REAL-TIME: SLA Monitoring (contoh dummy SLA 48 jam) ===
        $slaMonitoring = Ticket::select('id', 'title', 'status', 'created_at')
            ->limit(10)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                $deadline = Carbon::parse($ticket->created_at)->addHours(48);
                $remaining = now()->diffInHours($deadline, false);

                $slaStatus = match (true) {
                    $remaining < 0 => 'Terlambat',
                    $remaining <= 6 => 'Peringatan',
                    $remaining <= 24 => 'Normal',
                    default => 'Terbuka',
                };

                $badge = match ($slaStatus) {
                    'Terlambat' => 'bg-danger',
                    'Peringatan' => 'bg-warning text-dark',
                    'Normal' => 'bg-success',
                    'Tertunda' => 'bg-secondary',
                    default => 'bg-primary',
                };

                return [
                    'id' => 'TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT),
                    'title' => $ticket->title,
                    'status' => $slaStatus,
                    'badge' => $badge,
                    'created_at' => $ticket->created_at,
                    'deadline' => $deadline,
                ];
            });

        // === TAB NOTIFIKASI ===
        $notifications = Notification::where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();

        // === FEEDBACK (untuk rating rata-rata misalnya) ===
        $averageFeedback = FeedbackSurvey::avg('nilai');

        // === KIRIM SEMUA DATA KE VIEW ===
        return view('pages.dashboards.index', compact(
            'totalTickets',
            'totalCancelledCertificates',
            'totalDisputes',
            'resolutionRate',
            'monthlyTrends',
            'disputeByCategory',
            'latestTickets',
            'regionalDistribution',
            'ticketStatusStats',
            'recentActivities',
            'slaMonitoring',
            'notifications',
            'averageFeedback'
        ));
    }
}