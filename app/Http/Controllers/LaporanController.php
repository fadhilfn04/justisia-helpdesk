<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use App\Models\Ticket;
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
        $trenTiket = $this->getTrenTiketHarian($periode);

        return view('pages.laporan.index', compact(
            'statistik',
            'kinerjaBulanan',
            'distribusiKategori',
            'kinerjaAgen',
            'trenSLA',
            'kinerjaRegional',
            'trenTiket'
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
        return [
            'total_tiket' => 152,
            'tiket_selesai' => 120,
            'tiket_proses' => 25,
            'tiket_open' => 7,
            'rata_rata_sla' => '2.5 hari',
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

    private function getDistribusiKategori($periode, $wilayah)
    {
        return [
            ['kategori' => 'Sengketa Batas', 'jumlah' => 45],
            ['kategori' => 'Konflik Kepemilikan', 'jumlah' => 30],
            ['kategori' => 'Cacat Administrasi', 'jumlah' => 20],
            ['kategori' => 'Putusan Pengadilan', 'jumlah' => 10],
        ];
    }

    private function getKinerjaAgen($periode, $wilayah)
    {
        return [
            ['nama' => 'Rizky Pratama', 'tiket_selesai' => 40, 'sla_rata' => 2.3],
            ['nama' => 'Yusuf Ahmad', 'tiket_selesai' => 35, 'sla_rata' => 2.8],
            ['nama' => 'Siti Aisyah', 'tiket_selesai' => 30, 'sla_rata' => 3.1],
        ];
    }

    private function getTrenSLA($periode)
    {
        return [
            ['minggu' => 'Minggu 1', 'rata_sla' => 2.5],
            ['minggu' => 'Minggu 2', 'rata_sla' => 2.3],
            ['minggu' => 'Minggu 3', 'rata_sla' => 2.9],
            ['minggu' => 'Minggu 4', 'rata_sla' => 2.7],
        ];
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
        return [
            ['tanggal' => '2025-10-01', 'jumlah' => 12],
            ['tanggal' => '2025-10-02', 'jumlah' => 15],
            ['tanggal' => '2025-10-03', 'jumlah' => 8],
            ['tanggal' => '2025-10-04', 'jumlah' => 20],
        ];
    }
}