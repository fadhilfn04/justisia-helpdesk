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
                    ->where('action', '!=', 'Ticket Created')
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

        $slaBatasJam = 72;
        $slaCompliance = (clone $query)
            ->where('status', 'closed')
            ->get()
            ->filter(function ($ticket) use ($slaBatasJam) {
                $durasi = Carbon::parse($ticket->created_at)
                    ->diffInHours(Carbon::parse($ticket->updated_at));
                return $durasi <= $slaBatasJam;
            })
            ->count();

        $totalClosed = (clone $query)->where('status', 'closed')->count();
        $slaCompliancePersen = $totalClosed > 0
            ? round(($slaCompliance / $totalClosed) * 100, 2)
            : 0;

        return [
            'total_tiket' => $totalTiket,
            'tiket_selesai' => $tiketSelesai,
            'tiket_proses' => $tiketProses,
            'tiket_open' => $tiketOpen,
            'rata_rata_sla' => round($rataRataSlaJam / 24, 2)   ,
            'rata_rata_waktu_respon' => round($rataRataWaktuResponJam, 2),
            'tingkat_penyelesaian' => $tingkatPenyelesaian,
            'sla_compliance' => $slaCompliancePersen,
        ];
    }

    public function getAgenOnline(): JsonResponse
    {
        $onlineThreshold = now()->subMinutes(5);

        $totalAgen = User::where('role_id', 2)->count();
        $agenOnline = User::where('role_id', 2)
            ->where('last_seen', '>=', $onlineThreshold)
            ->count();

        return response()->json([
            'agen_online' => $agenOnline,
            'total_agen' => $totalAgen,
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

    private function getRecentActivities()
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
        return Ticket::select('id', 'title', 'status', 'created_at')
            ->orderByDesc('created_at')
            ->limit(10)
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
    }

    private function getUnreadNotifications()
    {
        return Notification::where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();
    }
}