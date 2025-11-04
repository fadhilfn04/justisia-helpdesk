<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\TicketCategory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        $judul = [
            'Permintaan Reset Password',
            'Gangguan Akses Sistem',
            'Perbaikan Data Pegawai',
            'Error Saat Login',
            'Tidak Bisa Upload Dokumen',
            'Laporan Keterlambatan Sistem',
            'Permintaan Fitur Baru',
            'Notifikasi Tidak Masuk Email',
        ];

        $deskripsi = [
            'Pengguna mengalami kendala saat mencoba login ke sistem dan muncul pesan error tidak dikenal.',
            'Diperlukan bantuan untuk memperbaiki data pegawai yang salah pada sistem.',
            'Permintaan untuk menambahkan fitur baru agar proses input data lebih efisien.',
            'Pengguna tidak menerima email verifikasi setelah mendaftar.',
            'Laporan adanya gangguan sistem yang membuat proses input menjadi lambat.',
        ];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'category_id' => TicketCategory::inRandomOrder()->first()->id ?? 1,
            'assigned_to' => User::where('role_id', 2)->inRandomOrder()->first()->id ?? null,
            'title' => $this->faker->randomElement($judul),
            'description' => $this->faker->randomElement($deskripsi),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
        ];
    }
}