<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $embeddingService;

    // public function __construct(EmbeddingService $embeddingService)
    // {
    //     $this->embeddingService = $embeddingService;
    // }

    public function index()
    {
        $faqs = Faq::with('category')->latest()->paginate(10);
        $categories = TicketCategory::latest()->paginate(10);
        return view('pages.admin.faq.index', compact('faqs', 'categories'));
    }

    public function show()
    {
        $faqs = Faq::with('category')->get();
        return response()->json(
            ['data' => $faqs]
        );
    }

    public function create()
    {
        return view('pages.admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_id' => 'nullable|integer'
        ]);

        $faq = Faq::create($request->only('question', 'answer', 'category_id'));

        // Generate embedding pakai IndoBERT
        // $faq->embedding = $this->embeddingService->generateEmbedding($faq->question);
        $faq->save();

        return redirect()->route('settings.faq.index')->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return response()->json($faq);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category_id' => 'nullable|integer'
        ]);

        $faq->update($request->only('question', 'answer', 'category_id'));

        // Jika kamu pakai embedding service nanti, bisa aktifkan lagi ini:
        // $faq->embedding = $this->embeddingService->generateEmbedding($faq->question);
        // $faq->save();

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil diperbarui!',
            'data' => $faq
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil dihapus!'
        ]);
    }
}