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
                    'question' => 'Bagaimana cara memantau status tiket yang masuk?',
                    'answer' => 'Admin dapat memantau status tiket melalui dashboard aplikasi pada menu monitoring tiket.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana menugaskan tiket kepada petugas?',
                    'answer' => 'Admin dapat menugaskan tiket dengan memilih tiket dan menentukan petugas yang bertanggung jawab pada detail tiket.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana mengubah status tiket menjadi selesai?',
                    'answer' => 'Status tiket dapat diubah menjadi selesai melalui menu detail tiket setelah penanganan selesai dilakukan.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana cara melihat riwayat penanganan sengketa?',
                    'answer' => 'Riwayat penanganan sengketa dapat dilihat pada menu laporan atau histori tiket di aplikasi.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana menambahkan kategori FAQ baru?',
                    'answer' => 'Kategori FAQ dapat ditambahkan melalui menu pengaturan FAQ di dashboard admin.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana mengelola data pengguna aplikasi?',
                    'answer' => 'Data pengguna dapat dikelola melalui menu manajemen pengguna di dashboard admin.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana mengakses laporan bulanan penanganan sengketa?',
                    'answer' => 'Laporan bulanan dapat diakses melalui menu laporan pada dashboard admin.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana menghapus tiket yang tidak valid?',
                    'answer' => 'Tiket yang tidak valid dapat dihapus melalui menu detail tiket dengan memilih opsi hapus.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana mengatur hak akses pengguna?',
                    'answer' => 'Hak akses pengguna dapat diatur melalui menu manajemen peran dan izin di dashboard admin.',
                    'category_id' => 1
                ],
                [
                    'question' => 'Bagaimana menghubungi support teknis aplikasi?',
                    'answer' => 'Support teknis dapat dihubungi melalui kontak yang tersedia di menu bantuan atau pengaturan aplikasi.',
                    'category_id' => 1
                ],
            ]);
    }
}
