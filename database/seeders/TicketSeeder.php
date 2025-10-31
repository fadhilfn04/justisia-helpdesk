<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketCategory;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada kategori, kalau belum maka buat beberapa
        if (TicketCategory::count() === 0) {
            $categories = [
                ['name' => 'Masalah Teknis', 'description' => 'Kendala teknis pada sistem atau aplikasi'],
                ['name' => 'Tagihan & Pembayaran', 'description' => 'Masalah terkait tagihan atau transaksi pembayaran'],
                ['name' => 'Akses Akun', 'description' => 'Permasalahan login atau verifikasi akun'],
                ['name' => 'Permintaan Fitur', 'description' => 'Saran atau ide pengembangan fitur baru'],
                ['name' => 'Pertanyaan Umum', 'description' => 'Pertanyaan umum terkait layanan'],
            ];

            foreach ($categories as $category) {
                TicketCategory::create($category);
            }
        }

        Ticket::factory()->count(30)->create();
    }
}