<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Notification;
use App\Models\FeedbackSurvey;
use App\Models\TicketTimeline;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets = Ticket::count();
        $ticketStatus = $this->getStatusTiket();
        $agenStats = $this->getAgenOnlineStats();
        $totalCancelledCertificates = Ticket::where('category_id', 2)->count();
        $totalDisputes = Ticket::where('category_id', 3)->count();
        $resolutionRate = $this->getResolutionRate($totalTickets);

        $monthlyTrends = $this->getMonthlyTrends();
        $disputeByCategory = $this->getDisputeByCategory();
        $latestTickets = $this->getLatestTickets();
        $regionalDistribution = $this->getRegionalDistribution();
        $ticketStatusStats = $this->getTicketStatusStats();
        $recentActivities = $this->getRecentActivities();
        $slaMonitoring = $this->getSlaMonitoring();
        $notifications = $this->getUnreadNotifications();
        $averageFeedback = FeedbackSurvey::avg('nilai');

        return view('pages.dashboards.index', compact(
            'totalTickets',
            'ticketStatus',
            'agenStats',
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

    private function getStatusTiket()
    {
        $query = Ticket::query();

        $totalTiket = (clone $query)->count();
        $tiketSelesai = (clone $query)->where('status', 'closed')->count();
        $tiketProses = (clone $query)->where('status', 'in_progress')->count();
        $tiketOpen = (clone $query)->where('status', 'open')->count();

        $tiketHariIni = (clone $query)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->subMonth()->year;

        $tiketBulanIni = (clone $query)
            ->whereYear('created_at', $tahunIni)
            ->whereMonth('created_at', $bulanIni)
            ->count();

        $tiketBulanLalu = (clone $query)
            ->whereYear('created_at', $tahunLalu)
            ->whereMonth('created_at', $bulanLalu)
            ->count();

        if ($tiketBulanLalu > 0) {
            $persentaseKenaikan = round((($tiketBulanIni - $tiketBulanLalu) / $tiketBulanLalu) * 100, 2);
        } else {
            $persentaseKenaikan = $tiketBulanIni > 0 ? 100 : 0;
        }

        $rataRataSlaJam = (clone $query)
            ->where('status', 'closed')
            ->get()
            ->map(function ($ticket) {
                return Carbon::parse($ticket->created_at)
                    ->diffInHours(Carbon::parse($ticket->updated_at));
            })
            ->avg() ?? 0;

        $rataRataWaktuResponJam = (clone $query)
            ->get()
            ->map(function ($ticket) {
                $firstResponse = TicketTimeline::where('ticket_id', $ticket->id)
                    ->where('action', '!=', 'Ticket Dibuat')
                    ->orderBy('created_at', 'asc')
                    ->first();

                return $firstResponse
                    ? Carbon::parse($ticket->created_at)->diffInHours(Carbon::parse($firstResponse->created_at))
                    : null;
            })
            ->filter()
            ->avg() ?? 0;

        $tingkatPenyelesaian = $totalTiket > 0
            ? round(($tiketSelesai / $totalTiket) * 100, 2)
            : 0;

        $slaCompliance = (clone $query)
            ->where('status', 'closed')
            ->get()
            ->filter(function ($ticket) {
                $batasJam = match ($ticket->priority) {
                    'high'   => 24,
                    'medium' => 48,
                    'low'    => 72,
                    default  => 48,
                };

                $durasi = Carbon::parse($ticket->created_at)
                    ->diffInHours(Carbon::parse($ticket->updated_at));

                return $durasi <= $batasJam;
            })
            ->count();

        $totalClosed = (clone $query)
            ->where('status', 'closed')
            ->count();

        $slaCompliancePersen = $totalClosed > 0
            ? round(($slaCompliance / $totalClosed) * 100, 2)
            : 0;

        return [
            'total_tiket' => $totalTiket,
            'tiket_selesai' => $tiketSelesai,
            'tiket_proses' => $tiketProses,
            'tiket_open' => $tiketOpen,
            'tiket_hari_ini' => $tiketHariIni,
            'rata_rata_sla' => round($rataRataSlaJam / 24, 2),
            'rata_rata_waktu_respon' => round($rataRataWaktuResponJam, 2),
            'tingkat_penyelesaian' => $tingkatPenyelesaian,
            'sla_compliance' => $slaCompliancePersen,
            'kenaikan_tiket_bulan_ini' => $persentaseKenaikan,
            'tiket_bulan_ini' => $tiketBulanIni,
            'tiket_bulan_lalu' => $tiketBulanLalu,
        ];
    }

    public function getRealtimeData()
    {
        $statusTiket = $this->getStatusTiket();
        $onlineAgents = $this->getAgenOnlineStats();
        $recentActivities = $this->getRecentActivities();
        $ticketDailyTrends = $this->getDailyTrends();
        $slaMonitoring = $this->getSlaMonitoring();

        return response()->json([
            'ticket_status' => $statusTiket,
            'online_agents' => $onlineAgents,
            'ticket_daily_trends' => $ticketDailyTrends,
            'sla_monitoring' => $slaMonitoring,
            'last_update' => now()->format('H:i:s'),
            'htmlActivities' => view('partials.dashboard.tables._aktivitas-real-time', compact('recentActivities'))->render(),
            'htmlSLA' => view('partials.dashboard.tables._monitoring-sla', compact('slaMonitoring'))->render(),
        ]);
    }

    private function getAgenOnlineStats()
    {
        $totalAgen = User::where('role_id', 2)->count();

        $onlineThreshold = now()->subMinutes(5);

        $agenOnline = User::where('role_id', 2)
            ->where('last_seen', '>=', $onlineThreshold)
            ->count();

        return [
            'agen_online' => $agenOnline,
            'total_agen' => $totalAgen,
        ];
    }

    private function getResolutionRate($totalTickets)
    {
        $closed = Ticket::where('status', 'closed')->count();
        return $closed > 0
            ? round(($closed / $totalTickets) * 100, 2)
            : 0;
    }

    private function getMonthlyTrends()
    {
        $monthlyData = Ticket::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw("SUM(CASE WHEN status != 'Selesai' THEN 1 ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai")
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $months = collect(range(1, 12));

        return [
            'categories' => $months->map(fn($m) => $monthNames[$m - 1]),
            'masuk' => $months->map(fn($m) => $monthlyData->firstWhere('month', $m)->masuk ?? 0),
            'selesai' => $months->map(fn($m) => $monthlyData->firstWhere('month', $m)->selesai ?? 0),
        ];
    }

    public function getDailyTrends()
    {
        $today = now()->toDateString();

        $dailyData = Ticket::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw("SUM(CASE WHEN status != 'Selesai' THEN 1 ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai")
            )
            ->whereDate('created_at', $today)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $hours = collect(range(0, 23))->map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00');

        return [
            'categories' => $hours,
            'masuk' => $hours->map(fn($h) => $dailyData->firstWhere('hour', (int) substr($h, 0, 2))->masuk ?? 0),
            'selesai' => $hours->map(fn($h) => $dailyData->firstWhere('hour', (int) substr($h, 0, 2))->selesai ?? 0),
        ];
    }

    private function getDisputeByCategory()
    {
        $query = Ticket::query();

        $kategoriData = $query
            ->select('category_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori' => $item->category->name ?? 'Tidak Diketahui',
                    'jumlah' => $item->jumlah
                ];
            });

        return $kategoriData;
    }

    private function getLatestTickets()
    {
        return Ticket::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();
    }

    private function getRegionalDistribution()
    {
        return User::select(DB::raw('LEFT(phone, 4) as region'), DB::raw('COUNT(*) as total'))
            ->groupBy('region')
            ->get();
    }

    private function getTicketStatusStats()
    {
        return Ticket::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
    }

    public function getRecentActivities()
    {
        return DB::table('ticket_timelines')
            ->join('tickets', 'ticket_timelines.ticket_id', '=', 'tickets.id')
            ->join('users', 'ticket_timelines.actor_id', '=', 'users.id')
            ->select('ticket_timelines.*', 'tickets.title as ticket_title', 'users.name as actor_name')
            ->orderByDesc('ticket_timelines.created_at')
            ->limit(5)
            ->get();
    }

    private function getSlaMonitoring()
    {
        return Ticket::select('id', 'title', 'status', 'priority', 'created_at', 'verified_at', 'sla_due_at')
            ->orderByDesc('verified_at')
            ->limit(10)
            ->get()
            ->map(function ($ticket) {
                if (!$ticket->verified_at) {
                    return [
                        'id' => 'TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT),
                        'title' => $ticket->title,
                        'status' => 'Menunggu Verifikasi',
                        'badge' => 'bg-secondary',
                        'created_at' => $ticket->created_at,
                        'deadline' => null,
                    ];
                }

                $deadline = $ticket->sla_due_at ?? match ($ticket->priority) {
                    'high' => Carbon::parse($ticket->verified_at)->addHours(24),
                    'medium' => Carbon::parse($ticket->verified_at)->addHours(48),
                    'low' => Carbon::parse($ticket->verified_at)->addHours(72),
                    default => Carbon::parse($ticket->verified_at)->addHours(48),
                };

                $remaining = now()->diffInHours($deadline, false);

                $slaStatus = match (true) {
                    $remaining < 0 => 'Terlambat',
                    $remaining <= 6 => 'Peringatan',
                    $remaining <= 24 => 'Normal',
                    default => 'Terbuka',
                };

                $badge = match ($slaStatus) {
                    'Terlambat' => 'bg-danger text-white',
                    'Peringatan' => 'bg-warning text-white',
                    'Normal' => 'bg-success text-white',
                    'Terbuka' => 'bg-primary text-white',
                    default => 'bg-secondary',
                };

                return [
                    'id' => 'TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT),
                    'title' => $ticket->title,
                    'priority' => ucfirst($ticket->priority),
                    'status' => $slaStatus,
                    'badge' => $badge,
                    'verified_at' => $ticket->verified_at,
                    'deadline' => $deadline,
                    'created_at' => $ticket->created_at,
                ];
            });
    }

    private function getUnreadNotifications()
    {
        return Notification::where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();
    }
}