<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    public function index()
    {
        $ticketCategory = TicketCategory::latest()->paginate(10);
        return view('pages.admin.ticket-category.index', compact('ticketCategory'));
    }

    public function show()
    {
        $ticketCategory = TicketCategory::get();
        return response()->json(
            ['data' => $ticketCategory]
        );
    }

    public function create()
    {
        return view('pages.admin.ticket-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $ticketCategory = TicketCategory::create($request->only('name', 'description'));
        $ticketCategory->save();

        return redirect()->route('settings.ticket-category.index')->with('success', 'Kategori Tiket berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ticketCategory = TicketCategory::findOrFail($id);
        return response()->json($ticketCategory);
    }

    public function update(Request $request, TicketCategory $ticketCategory)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $ticketCategory->update($request->only('name', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Kategori Tiket berhasil diperbarui!',
            'data' => $ticketCategory
        ]);
    }

    public function destroy(TicketCategory $ticketCategory)
    {
        $ticketCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori Tiket berhasil dihapus!'
        ]);
    }
}
