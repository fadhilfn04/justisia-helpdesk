<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use App\Models\Region;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketTimeline;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah_id');
        $kategori = $request->get('kategori_id');

        $periode = $request->input('periode', 'Bulanan');
        $wilayah = $request->input('wilayah', 'Semua Wilayah');
        $kategori = $request->input('kategori', 'Semua Kategori');

        $statistikKinerja = $this->getStatistik();
        $statistik = $this->getStatistikKinerja($periode, $wilayah, $kategori);
        $kinerjaBulanan = $this->getKinerjaBulanan($periode, $wilayah);
        $distribusiKategori = $this->getDistribusiKategori($periode, $wilayah);

        $kinerjaAgen = $this->getKinerjaAgen($periode, $wilayah);
        $trenSLA = $this->getTrenSLA($periode);
        $kinerjaRegional = $this->getKinerjaRegional($periode);
        $trenTiketHarian = $this->getTrenTiketHarian($periode);

        $daftarWilayah = Region::orderBy('name')->get();
        $daftarKategori = TicketCategory::orderBy('name')->get();

        return view('pages.laporan.index', compact(
            'statistik',
            'statistikKinerja',
            'kinerjaBulanan',
            'distribusiKategori',
            'kinerjaAgen',
            'trenSLA',
            'kinerjaRegional',
            'trenTiketHarian',
            'daftarWilayah',
            'daftarKategori'
        ));
    }

    public function filterStatistikKinerja(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getStatistikKinerja($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getStatistikKinerja($periode = null, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query();

        if (!empty($wilayah)) {
            $query->where('wilayah_id', $wilayah);
        }

        if (!empty($kategori)) {
            $query->where('category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

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
            'rata_rata_sla' => round($rataRataSlaJam / 24, 2),
            'rata_rata_waktu_respon' => round($rataRataWaktuResponJam, 2),
            'tingkat_penyelesaian' => $tingkatPenyelesaian,
            'sla_compliance' => $slaCompliancePersen,
        ];
    }

    private function getStatistik()
    {
        $tiket = Ticket::selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as bulan,
                COUNT(*) as total_masuk,
                SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as total_selesai
            ")
            ->where('created_at', '>=', now()->subMonths(3))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $rataMasuk = $tiket->avg('total_masuk') ?? 0;
        $rataSelesai = $tiket->avg('total_selesai') ?? 0;

        $last = $tiket->last();
        $prev = $tiket->count() > 1 ? $tiket[$tiket->count() - 2] : $last;

        $growthRate = $prev && $prev->total_masuk > 0
            ? (($last->total_masuk - $prev->total_masuk) / $prev->total_masuk) * 100
            : 0;

        $prediksiMasuk = round($last->total_masuk * (1 + $growthRate / 100));
        $prediksiSelesai = round($prediksiMasuk * ($rataSelesai / max($rataMasuk, 1)));
        $backlog = max($prediksiMasuk - $prediksiSelesai, 0);

        return [
            'prediksi_tiket_masuk' => $prediksiMasuk,
            'growth' => round($growthRate, 1),
            'prediksi_selesai' => $prediksiSelesai,
            'completion_rate' => $rataMasuk > 0 ? round(($rataSelesai / $rataMasuk) * 100, 1) : 0,
            'backlog' => $backlog,
        ];
    }

    public function filterKinerjaBulanan(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getKinerjaBulanan($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getKinerjaBulanan($periode = null, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query();

        if (!empty($wilayah)) {
            $query->where('wilayah_id', $wilayah);
        }

        if (!empty($kategori)) {
            $query->where('category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

        $data = $query
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw("SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN status IN ('open', 'in_progress') THEN 1 ELSE 0 END) as masuk")
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulanNama = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        return $data->map(function ($row) use ($bulanNama) {
            return [
                'bulan' => $bulanNama[$row->bulan] ?? $row->bulan,
                'selesai' => (int) $row->selesai,
                'masuk' => (int) $row->masuk,
            ];
        });
    }

    public function filterDistribusiKategori(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getDistribusiKategori($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getDistribusiKategori($periode = null, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query();

        if (!empty($wilayah)) {
            $query->where('wilayah_id', $wilayah);
        }

        if (!empty($kategori)) {
            $query->where('category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

        $kategoriData = $query
            ->select('category_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori' => $item->category->name ?? 'Tidak Diketahui',
                    'jumlah' => (int) $item->jumlah,
                ];
            });

        return $kategoriData;
    }

    public function filterKinerjaAgen(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getKinerjaAgen($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getKinerjaAgen($periode, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query()
            ->where('status', 'closed')
            ->whereNotNull('assigned_to');

        if (!empty($wilayah)) {
            $query->where('wilayah_id', $wilayah);
        }

        if (!empty($kategori)) {
            $query->where('category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

        $data = $query
            ->select('assigned_to', DB::raw('COUNT(*) as tiket_selesai'))
            ->groupBy('assigned_to')
            ->with('agent:id,name')
            ->get()
            ->map(function ($item) use ($periode, $wilayah, $kategori) {
                $slaQuery = Ticket::where('assigned_to', $item->assigned_to)
                    ->where('status', 'closed');

                if ($wilayah) {
                    $slaQuery->where('wilayah_id', $wilayah);
                }
                if ($kategori) {
                    $slaQuery->where('category_id', $kategori);
                }
                if ($periode && isset($periode['start']) && isset($periode['end'])) {
                    $slaQuery->whereBetween('updated_at', [$periode['start'], $periode['end']]);
                }

                $slaRata = $slaQuery->get()
                    ->map(fn($ticket) => Carbon::parse($ticket->created_at)->diffInHours($ticket->updated_at) / 24)
                    ->avg();

                return [
                    'nama' => $item->agent->name ?? 'Tidak Diketahui',
                    'tiket_selesai' => (int) $item->tiket_selesai,
                    'sla_rata' => round($slaRata ?? 0, 2),
                    'rating' => round(rand(42, 50) / 10, 1),
                ];
            });

        return $data;
    }

    public function filterTrenSla(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getTrenSLA($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getTrenSLA($periode = null, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query()
            ->select('id', 'status', 'priority', 'verified_at', 'created_at', 'updated_at', 'sla_due_at')
            ->whereNotNull('verified_at');

        if ($wilayah) {
            $query->where('wilayah_id', $wilayah);
        }

        if ($kategori) {
            $query->where('category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('created_at', [$start, $end]);
        }

        $tickets = $query->get()->groupBy(function ($ticket) {
            return Carbon::parse($ticket->created_at)->format('oW');
        });

        $data = $tickets->map(function ($group, $mingguKe) {
            $closedTickets = $group->where('status', 'closed');

            $slaHari = $closedTickets->map(function ($ticket) {
                $deadline = $ticket->sla_due_at ?? match ($ticket->priority) {
                    'high' => Carbon::parse($ticket->verified_at)->addHours(24),
                    'medium' => Carbon::parse($ticket->verified_at)->addHours(48),
                    'low' => Carbon::parse($ticket->verified_at)->addHours(72),
                    default => Carbon::parse($ticket->verified_at)->addHours(48),
                };

                $selesai = Carbon::parse($ticket->updated_at ?? now());
                $durasiJam = Carbon::parse($ticket->verified_at)->diffInHours($selesai);
                return round($durasiJam / 24, 2);
            });

            $rataSLA = $slaHari->count() > 0 ? round($slaHari->avg(), 2) : 0;

            $tingkatPenyelesaian = $group->count() > 0
                ? round(($closedTickets->count() / $group->count()) * 100, 2)
                : 0;

            $tahun = substr($mingguKe, 0, 4);
            $minggu = intval(substr($mingguKe, 4));

            return [
                'minggu' => "Minggu " . $minggu,
                'rata_sla' => $rataSLA,
                'tingkat_penyelesaian' => $tingkatPenyelesaian,
            ];
        })->values();

        return $data;
    }

    public function filterKinerjaRegional(Request $request)
    {
        $periode = $request->get('periode', 'monthly');
        $wilayah = $request->get('wilayah');
        $kategori = $request->get('kategori');

        $data = $this->getKinerjaRegional($periode, $wilayah, $kategori);

        return response()->json($data);
    }

    private function getKinerjaRegional($periode = null, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query()
            ->selectRaw("
                regions.name as nama_wilayah,
                COUNT(tickets.id) as total_tiket,
                AVG(TIMESTAMPDIFF(HOUR, tickets.created_at, tickets.updated_at)) / 24 as rata_respon_hari,
                SUM(CASE WHEN tickets.status = 'closed' THEN 1 ELSE 0 END) / COUNT(*) * 100 as tingkat_penyelesaian
            ")
            ->join('regions', 'regions.id', '=', 'tickets.wilayah_id')
            ->whereNotNull('tickets.wilayah_id')
            ->where('tickets.status', 'closed');

        if (!empty($wilayah)) {
            $query->where('tickets.wilayah_id', $wilayah);
        }

        if (!empty($kategori)) {
            $query->where('tickets.category_id', $kategori);
        }

        if (!empty($periode)) {
            switch ($periode) {
                case 'daily':
                    $start = now()->startOfDay();
                    $end = now()->endOfDay();
                    break;
                case 'weekly':
                    $start = now()->startOfWeek();
                    $end = now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = now()->startOfMonth();
                    $end = now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = now()->startOfYear();
                    $end = now()->endOfYear();
                    break;
                default:
                    $start = now()->subMonths(3);
                    $end = now();
                    break;
            }

            $query->whereBetween('tickets.created_at', [$start, $end]);
        }

        $data = $query->groupBy('regions.name')
            ->orderByDesc('total_tiket')
            ->get()
            ->map(function ($item) {
                return [
                    'wilayah' => $item->nama_wilayah,
                    'tiket_selesai' => (int) $item->total_tiket,
                    'rata_respon' => round($item->rata_respon_hari ?? 0, 2),
                    'tingkat_penyelesaian' => round($item->tingkat_penyelesaian ?? 0, 2),
                ];
            });

        return $data;
    }

    private function getTrenTiketHarian($periode)
    {
        $tren = DB::table('tickets')
            ->selectRaw("
                DATE(created_at) as tanggal,
                COUNT(*) as tiket_masuk,
                SUM(CASE WHEN status IN ('resolved', 'closed') THEN 1 ELSE 0 END) as tiket_selesai,
                ROUND(SUM(CASE WHEN status IN ('resolved', 'closed') THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) as tingkat_penyelesaian,
                ROUND(AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)), 2) as rata_rata_respon_jam,
                ROUND(SUM(CASE WHEN status IN ('resolved', 'closed') AND TIMESTAMPDIFF(HOUR, created_at, updated_at) <= 72 THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) as sla_compliance
            ")
            // ->whereBetween('created_at', [$periode['mulai'], $periode['selesai']])
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        return $tren;
    }
}