<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        TicketCategory::insert([
            ['name' => 'Teknis', 'description' => 'Permasalahan teknis terkait sistem'],
            ['name' => 'Akun', 'description' => 'Masalah login atau reset password'],
            ['name' => 'Lainnya', 'description' => 'Pertanyaan umum lainnya'],
        ]);
    }
}