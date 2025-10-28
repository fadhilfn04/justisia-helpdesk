<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class PembatalanSertifikatController extends Controller
{
    public function index()
    {
        return view('pages.pembatalan-sertifikat.index');
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:ticket_categories,id',
            'priority' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $file->store('attachments');
            }
        }

        return redirect()->route('helpdesk.index')->with('success', 'Tiket berhasil dibuat!');
    }

    public function edit(Ticket $ticket) {}

    public function update(Request $request, Ticket $ticket) {}

    // public function destroy(Ticket $ticket)
    // {
    //     $ticket->delete();
    //     return redirect()->route('tiket.index')->with('success', 'Data tiket berhasil dihapus.');
    // }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xls,xlsx'
    //     ]);

    //     try {
    //         Excel::import(new KaryawanImport, $request->file('file'));

    //         return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diimport!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('karyawan.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
    //     }
    // }
}
