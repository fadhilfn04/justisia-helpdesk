<?php

namespace App\Http\Controllers;

use App\Models\PembatalanSertifikat;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PembatalanSertifikatController extends Controller
{
    public function index()
    {
        $data = PembatalanSertifikat::all();

        return view('pages.pembatalan-sertifikat.index', compact('data'));
    }

    public function create()
    {
        return view('pages.pembatalan-sertifikat.create');
    }

    public function cacat_administrasi()
    {
        return view('pages.pembatalan-sertifikat.cacat_administrasi');
    }

    public function putusan_pengadilan()
    {
        return view('pages.pembatalan-sertifikat.putusan_pengadilan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'penanggung_jawab' => 'nullable|string|max:255',
            'target_selesai' => 'nullable|date',
        ]);

        PembatalanSertifikat::create([
            'id_pembatalan' => 'PB-' . Str::padLeft(PembatalanSertifikat::count() + 1, 3, '0'),
            'no_sertifikat' => $request->no_sertifikat,
            'pemilik' => $request->pemilik,
            'lokasi' => $request->lokasi,
            'jenis' => $request->jenis,
            'status' => $request->status,
            'penanggung_jawab' => $request->penanggung_jawab,
            'target_selesai' => $request->target_selesai,
        ]);

        return redirect()->route('pembatalan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(PembatalanSertifikat $pembatalan)
    {
        return view('pages.pembatalan_sertifikat.edit', compact('pembatalan'));
    }

    public function update(Request $request, PembatalanSertifikat $pembatalan)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'penanggung_jawab' => 'nullable|string|max:255',
            'target_selesai' => 'nullable|date',
        ]);

        $pembatalan->update($request->all());
        return redirect()->route('pembatalan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(PembatalanSertifikat $pembatalan)
    {
        $pembatalan->delete();
        return redirect()->route('pembatalan.index')->with('success', 'Data berhasil dihapus!');
    }
}
