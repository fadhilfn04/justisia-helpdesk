<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view("pages.help.faq");
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
