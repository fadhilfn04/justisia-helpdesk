<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use App\Models\Ticket;
use App\Models\TicketTimeline;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'Bulanan');
        $wilayah = $request->input('wilayah', 'Semua Wilayah');
        $kategori = $request->input('kategori', 'Semua Kategori');

        $statistik = $this->getStatistikKinerja($periode, $wilayah, $kategori);
        $kinerjaBulanan = $this->getKinerjaBulanan($periode, $wilayah);
        $distribusiKategori = $this->getDistribusiKategori($periode, $wilayah);

        $kinerjaAgen = $this->getKinerjaAgen($periode, $wilayah);
        $trenSLA = $this->getTrenSLA($periode);
        $kinerjaRegional = $this->getKinerjaRegional($periode);
        $trenTiketHarian = $this->getTrenTiketHarian($periode);

        return view('pages.laporan.index', compact(
            'statistik',
            'kinerjaBulanan',
            'distribusiKategori',
            'kinerjaAgen',
            'trenSLA',
            'kinerjaRegional',
            'trenTiketHarian'
        ));
    }

    // public function exportExcel(Request $request)
    // {
    //     $periode = $request->input('periode', 'Bulanan');
    //     return Excel::download(new LaporanExport($periode), "Laporan_{$periode}_" . now()->format('Ymd') . ".xlsx");
    // }

    // public function exportPDF(Request $request)
    // {
    //     $periode = $request->input('periode', 'Bulanan');
    //     $data = [
    //         'statistik' => $this->getStatistikKinerja($periode),
    //         'kinerjaBulanan' => $this->getKinerjaBulanan($periode),
    //     ];

    //     $pdf = PDF::loadView('pages.laporan.export-pdf', $data)->setPaper('a4', 'landscape');
    //     return $pdf->download("Laporan_{$periode}_" . now()->format('Ymd') . ".pdf");
    // }

    private function getStatistikKinerja($periode, $wilayah = null, $kategori = null)
    {
        $query = Ticket::query();

        // filter opsional
        // if ($wilayah) {
        //     $query->where('wilayah_id', $wilayah);
        // }

        // if ($kategori) {
        //     $query->where('kategori_id', $kategori);
        // }

        // if ($periode) {
        //     $query->whereBetween('created_at', [$periode['start'], $periode['end']]);
        // }

        $totalTiket = (clone $query)->count();
        $tiketSelesai = (clone $query)->where('status', 'closed')->count();
        $tiketProses = (clone $query)->where('status', 'in_progress')->count();
        $tiketOpen = (clone $query)->where('status', 'open')->count();

        // rata-rata SLA (dari created ke saat status closed)
        $rataRataSlaJam = (clone $query)
            ->where('status', 'closed')
            ->get()
            ->map(function ($ticket) {
                return Carbon::parse($ticket->created_at)
                    ->diffInHours(Carbon::parse($ticket->updated_at));
            })
            ->avg() ?? 0;

        // cari response pertama dari timeline
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

        // hitung tingkat penyelesaian (% tiket selesai)
        $tingkatPenyelesaian = $totalTiket > 0
            ? round(($tiketSelesai / $totalTiket) * 100, 2)
            : 0;

        // hitung SLA compliance (misal SLA dianggap 72 jam)
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

    private function getKinerjaBulanan($periode = null, $wilayah = null)
    {
        $data = Ticket::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw("SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as selesai"),
                DB::raw("SUM(CASE WHEN status IN ('open', 'in_progress') THEN 1 ELSE 0 END) as masuk")
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulanNama = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

        return $data->map(function ($row) use ($bulanNama) {
            return [
                'bulan' => $bulanNama[$row->bulan] ?? $row->bulan,
                'selesai' => (int) $row->selesai,
                'masuk' => (int) $row->masuk,
            ];
        });
    }

    private function getDistribusiKategori($periode, $wilayah = null)
    {
        $query = Ticket::query();

        // if ($wilayah) {
        //     $query->where('wilayah_id', $wilayah);
        // }

        // if ($periode) {
        //     $query->whereBetween('created_at', [$periode['start'], $periode['end']]);
        // }

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

    private function getKinerjaAgen($periode, $wilayah = null)
    {
        $query = Ticket::query()
            ->where('status', 'closed')
            ->whereNotNull('assigned_to');

        // if ($wilayah) {
        //     $query->where('wilayah_id', $wilayah);
        // }

        // if ($periode) {
        //     $query->whereBetween('updated_at', [$periode['start'], $periode['end']]);
        // }

        $data = $query
            ->select('assigned_to', DB::raw('COUNT(*) as tiket_selesai'))
            ->groupBy('assigned_to')
            ->with('agent:id,name')
            ->get()
            ->map(function ($item) {
                $slaRata = Ticket::where('assigned_to', $item->assigned_to)
                    ->where('status', 'closed')
                    ->get()
                    ->map(function ($ticket) {
                        return Carbon::parse($ticket->created_at)->diffInHours($ticket->updated_at) / 24;
                    })
                    ->avg();

                return [
                    'nama' => $item->agent->name ?? 'Tidak Diketahui',
                    'tiket_selesai' => $item->tiket_selesai,
                    'sla_rata' => round($slaRata ?? 0, 2),
                    'rating' => round(rand(42, 50) / 10, 1),
                ];
            });

        return $data;
    }

    private function getTrenSLA($periode)
    {
        $query = Ticket::selectRaw("
            YEARWEEK(created_at, 1) as minggu_ke,
            AVG(CASE WHEN status = 'closed' THEN TIMESTAMPDIFF(HOUR, created_at, updated_at) END) / 24 as rata_sla_hari,
            SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) / COUNT(*) * 100 as tingkat_penyelesaian
        ")
        ->groupBy('minggu_ke')
        ->orderBy('minggu_ke');

        $data = $query->get()->map(function ($item) {
            $tahun = substr($item->minggu_ke, 0, 4);
            $minggu = substr($item->minggu_ke, 4);
            return [
                'minggu' => "Minggu " . intval($minggu),
                'rata_sla' => round($item->rata_sla_hari ?? 0, 2),
                'tingkat_penyelesaian' => round($item->tingkat_penyelesaian ?? 0, 2),
            ];
        });

        return $data;
    }

    private function getKinerjaRegional($periode)
    {
        return [
            ['wilayah' => 'Jakarta', 'tiket_selesai' => 50, 'tiket_open' => 5],
            ['wilayah' => 'Bandung', 'tiket_selesai' => 40, 'tiket_open' => 4],
            ['wilayah' => 'Makassar', 'tiket_selesai' => 30, 'tiket_open' => 3],
        ];
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