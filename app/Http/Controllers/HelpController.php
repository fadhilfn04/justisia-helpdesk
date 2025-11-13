<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->get();

        $groupedFaqs = $faqs->groupBy(function ($faq) {
            return $faq->category->name ?? 'Umum';
        });

        $icons = [
            'Helpdesk' => 'ticket',
            'Pembatalan Sertifikat' => 'file-x',
            'Sengketa & Konflik' => 'chart-column',
            'Umum' => 'help-circle',
        ];

        return view('pages.help.faq', compact('groupedFaqs', 'icons'));
    }

    public function guide()
    {
        return view("pages.help.guide");
    }

    public function kontak()
    {
        return view("pages.help.kontak");
    }
}
