<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::insert([
            [
                'question' => 'Bagaimana cara membuat tiket baru?',
                'answer' => 'Masuk ke menu Helpdesk dan pilih Buat Tiket Baru.',
                'category_id' => 1
            ],
            [
                'question' => 'Bagaimana jika saya lupa password?',
                'answer' => 'Gunakan fitur Lupa Password di halaman login.',
                'category_id' => 2
            ],
        ]);
    }
}