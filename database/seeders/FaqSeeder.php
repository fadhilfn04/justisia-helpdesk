<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::insert([
            [ 'question'=>'Bagaimana cara membuat tiket laporan baru?', 'answer'=>'Pengguna dapat membuat tiket melalui menu Buat Tiket dan mengisi formulir yang tersedia.', 'category_id'=>1 ],
            [ 'question'=>'Apa perbedaan status tiket terbuka dan proses?', 'answer'=>'Terbuka berarti tiket baru dibuat, proses berarti tiket sedang ditangani petugas.', 'category_id'=>1 ],
            [ 'question'=>'Siapa saja yang dapat memantau perkembangan tiket?', 'answer'=>'Pengguna pembuat tiket, admin, dan petugas yang ditugaskan.', 'category_id'=>1 ],
            [ 'question'=>'Berapa lama tiket biasanya diproses?', 'answer'=>'Waktu penanganan tergantung kompleksitas kasus dan kelengkapan dokumen.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana cara memberikan feedback terhadap penyelesaian tiket?', 'answer'=>'Pengguna dapat memberikan penilaian dan komentar setelah tiket selesai melalui halaman detail tiket.', 'category_id'=>1 ],
            [ 'question'=>'Apa yang harus dilakukan jika tiket salah kategori?', 'answer'=>'Admin dapat memindahkan kategori tiket melalui pengaturan detail tiket.', 'category_id'=>1 ],
            [ 'question'=>'Apakah saya dapat menghapus tiket yang sudah dibuat?', 'answer'=>'Tiket hanya dapat dihapus oleh admin atau jika dinyatakan tidak valid.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana jika petugas terlalu lama merespon?', 'answer'=>'Sistem akan mengirim pengingat otomatis, dan admin dapat melakukan eskalasi.', 'category_id'=>1 ],
            [ 'question'=>'Apakah bukti screenshot dan foto boleh dilampirkan?', 'answer'=>'Ya, sistem mendukung unggah foto, PDF, dan beberapa format dokumen lain.', 'category_id'=>1 ],
            [ 'question'=>'Apakah saya bisa membuat tiket lebih dari satu?', 'answer'=>'Boleh, selama setiap tiket memiliki kasus independen dan jelas.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana jika saya lupa mengisi informasi penting?', 'answer'=>'Pengguna dapat memperbarui tiket selama belum masuk tahap penanganan.', 'category_id'=>1 ],
            [ 'question'=>'Siapa yang dapat menutup tiket?', 'answer'=>'Petugas dapat menutup tiket setelah penanganan selesai, pengguna dapat memberikan konfirmasi.', 'category_id'=>1 ],
            [ 'question'=>'Dimana saya bisa melihat sejarah/riwayat tiket saya?', 'answer'=>'Riwayat tiket dapat dilihat pada menu Riwayat atau Dashboard pengguna.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana cara mencari tiket berdasarkan nomor?', 'answer'=>'Gunakan fitur pencarian dan masukkan nomor tiket pada kolom search.', 'category_id'=>1 ],
            [ 'question'=>'Apa yang dimaksud tiket prioritas tinggi?', 'answer'=>'Tiket urgent dengan dampak besar atau sengketa serius yang membutuhkan respon cepat.', 'category_id'=>1 ],
            [ 'question'=>'Apakah saya bisa meminta review ulang keputusan tiket?', 'answer'=>'Ya, pengguna dapat meminta peninjauan ulang jika ada bukti tambahan.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana jika saya mengalami kendala akses akun?', 'answer'=>'Hubungi administrator untuk pemulihan akun atau reset kredensial.', 'category_id'=>1 ],
            [ 'question'=>'Kapan tiket dinyatakan selesai?', 'answer'=>'Ketika solusi diberikan dan disetujui oleh user atau disimpulkan final oleh mediator.', 'category_id'=>1 ],
            [ 'question'=>'Apakah tiket bisa dipindahkan ke petugas lain?', 'answer'=>'Admin dapat memindah penugasan tiket sesuai kebutuhan penanganan.', 'category_id'=>1 ],
            [ 'question'=>'Bolehkah saya membuat tiket untuk orang lain?', 'answer'=>'Boleh jika memiliki otorisasi dan data lengkap yang dibutuhkan.', 'category_id'=>1 ],
            [ 'question'=>'Bagaimana login ke sistem?', 'answer'=>'Masukkan email dan kata sandi pada halaman login, lalu tekan masuk.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana mengubah password akun?', 'answer'=>'Masuk menu pengaturan profil dan pilih Ubah Kata Sandi.', 'category_id'=>2 ],
            [ 'question'=>'Apa yang harus dilakukan jika tidak bisa upload file?', 'answer'=>'Pastikan ukuran file sesuai limit dan format diperbolehkan.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana mengaktifkan notifikasi email tiket?', 'answer'=>'Aktifkan toggle notifikasi pada menu pengaturan akun.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana jika tombol submit tidak merespon?', 'answer'=>'Refresh halaman atau bersihkan cache browser, coba kembali.', 'category_id'=>2 ],
            [ 'question'=>'Apakah sistem mendukung multi-device?', 'answer'=>'Ya, dapat diakses melalui desktop, tablet, dan mobile.', 'category_id'=>2 ],
            [ 'question'=>'Apa maksud session expired saat login?', 'answer'=>'Akun tidak aktif terlalu lama, cukup login ulang untuk melanjutkan.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana melihat log aktivitas?', 'answer'=>'Admin dapat melihat log melalui menu Sistem > Activity Log.', 'category_id'=>2 ],
            [ 'question'=>'Apakah bisa export tiket ke Excel?', 'answer'=>'Ya, tersedia tombol export pada tabel daftar tiket.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana cara backup data secara berkala?', 'answer'=>'Admin dapat mengaktifkan fitur backup otomatis pada menu sistem.', 'category_id'=>2 ],
            [ 'question'=>'Apakah data tiket terenkripsi?', 'answer'=>'Ya, sistem menggunakan encryption untuk menjaga keamanan informasi.', 'category_id'=>2 ],
            [ 'question'=>'Apakah aplikasi tetap berjalan jika server sibuk?', 'answer'=>'Sistem menggunakan queue untuk menjaga stabilitas saat trafik tinggi.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana melakukan restore database?', 'answer'=>'Hanya dapat dilakukan oleh admin pada panel backup & restore.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana melihat statistik tiket?', 'answer'=>'Halaman dashboard menampilkan grafik jumlah tiket berdasarkan status.', 'category_id'=>2 ],
            [ 'question'=>'Apakah bisa menambahkan role baru selain admin?', 'answer'=>'Ya, role dapat ditambahkan melalui modul manajemen akses.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana jika akun saya terdeteksi login ganda?', 'answer'=>'Sistem akan memberi notifikasi keamanan dan meminta verifikasi ulang.', 'category_id'=>2 ],
            [ 'question'=>'Apakah sistem mendukung two-factor authentication?', 'answer'=>'Ya, dapat diaktifkan melalui pengaturan keamanan pengguna.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana cara clear cache aplikasi?', 'answer'=>'Admin atau dev dapat menjalankan perintah artisan atau menu Maintenance.', 'category_id'=>2 ],
            [ 'question'=>'Mengapa grafik dashboard tidak muncul?', 'answer'=>'Kemungkinan blokir script. Cek koneksi dan izinkan JavaScript.', 'category_id'=>2 ],
            [ 'question'=>'Apakah sistem bisa terintegrasi dengan API eksternal?', 'answer'=>'Ya, API tersedia untuk integrasi sesuai kebutuhan.', 'category_id'=>2 ],
            [ 'question'=>'Bagaimana mengajukan laporan sengketa tanah?', 'answer'=>'Gunakan menu Buat Tiket dengan memilih kategori sengketa pertanahan.', 'category_id'=>3 ],
            [ 'question'=>'Dokumen apa saja yang wajib dilampirkan?', 'answer'=>'Biasanya KTP, bukti kepemilikan tanah, sertifikat, dan kronologi lengkap.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana jika tanah belum bersertifikat?', 'answer'=>'Lampirkan surat riwayat kepemilikan atau dokumen pendukung lainnya.', 'category_id'=>3 ],
            [ 'question'=>'Apakah sistem mendukung mediasi pihak berkonflik?', 'answer'=>'Ya, fitur mediasi dapat diajukan dari detail tiket.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana status proses klarifikasi pihak terkait?', 'answer'=>'Status akan berubah menjadi klarifikasi dokumen setelah pemeriksaan awal.', 'category_id'=>3 ],
            [ 'question'=>'Apakah keputusan mediasi bisa ditolak?', 'answer'=>'Pihak dapat meminta banding atau upload bukti baru.', 'category_id'=>3 ],
            [ 'question'=>'Siapa mediator sengketa pertanahan?', 'answer'=>'Mediator merupakan petugas resmi yang ditunjuk oleh lembaga.', 'category_id'=>3 ],
            [ 'question'=>'Berapa lama proses peninjauan bukti?', 'answer'=>'Kurang lebih 3—14 hari kerja tergantung kompleksitas kasus.', 'category_id'=>3 ],
            [ 'question'=>'Apa syarat pembukaan ulang kasus sengketa?', 'answer'=>'Harus ada bukti baru yang sah secara hukum.', 'category_id'=>3 ],
            [ 'question'=>'Apakah laporan sengketa bisa dicabut?', 'answer'=>'Ya, asal belum masuk tahap keputusan final.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana mengetahui jadwal mediasi?', 'answer'=>'Notifikasi jadwal mediasi muncul pada dashboard dan email.', 'category_id'=>3 ],
            [ 'question'=>'Apakah keputusan sengketa dapat dicetak?', 'answer'=>'Ya, tersedia fitur export PDF keputusan akhir.', 'category_id'=>3 ],
            [ 'question'=>'Siapa yang dapat melihat dokumen sengketa?', 'answer'=>'Hanya pihak berwenang dengan akses resmi.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana jika pihak tidak kooperatif?', 'answer'=>'Mediator dapat menjadwalkan pemanggilan ulang atau eskalasi tindak lanjut.', 'category_id'=>3 ],
            [ 'question'=>'Apakah lokasi tanah dapat diverifikasi melalui peta digital?', 'answer'=>'Ya, tersedia fitur mapping apabila koordinat lokasi tersedia.', 'category_id'=>3 ],
            [ 'question'=>'Apa yang terjadi jika dokumen palsu ditemukan?', 'answer'=>'Kasus langsung dievaluasi ulang dan dapat diproses hukum.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana pengajuan keberatan atas hasil keputusan?', 'answer'=>'Ajukan tiket keberatan disertai bukti pendukung tambahan.', 'category_id'=>3 ],
            [ 'question'=>'Bisakah dua tiket digabung jika objek sengketanya sama?', 'answer'=>'Ya, admin dapat merge tiket agar tidak duplikasi.', 'category_id'=>3 ],
            [ 'question'=>'Bagaimana melaporkan intimidasi antar pihak?', 'answer'=>'Laporkan melalui tiket dengan kategori ancaman/konflik.', 'category_id'=>3 ],
            [ 'question'=>'Apakah laporan sengketa bersifat rahasia?', 'answer'=>'Ya, seluruh data sengketa dilindungi dan tidak dipublikasikan.', 'category_id'=>3 ],
        ]);
    }
}