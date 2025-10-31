<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/help.css') }}">

<div class="content-wrapper">
    <header class="d-flex align-items-center gap-3 py-4 px-4">
        <div class="bg-light border d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
            <i data-lucide="book-open" class="text-dark" style="font-size: 2.5rem;"></i>
        </div>
        <div>
            <h1 class="h1 mb-1">Panduan Pengguna</h1>
            <p class="mb-0 fs-6">Tutorial dan panduan lengkap menggunakan aplikasi Justisia</p>
        </div>
    </header>

    <div class="container py-7">
        <div class="d-flex align-items-center position-relative" style="width: 35%;">
            {!! getIcon('magnifier','fs-3 position-absolute text-dark ms-5') !!}
            <input type="text" class="form-control form-control-solid bg-white input-soft-shadow ps-13" placeholder="Cari pertanyaan atau topik..." id="faqSearchInput"/>
        </div>
        <div class="row g-5 mt-7">
            <h2>Panduan Unggulan</h2>

            <div class="col-lg-12 mt-7">
                <div class="row">
                    <div class="col-lg-6">
                        {{-- Thumbnail 1 --}}
                        <div class="card bg-light border border-gray-300 overflow-hidden">
                            <div class="position-relative" style="height: 220px; overflow: hidden;">
                                <img src="{{ asset('assets/media/images-guide/land-dispute-guide.jpg') }}"
                                    class="w-100 h-100 object-fit-cover"
                                    alt="Panduan Sengketa Pertanahan">

                                <span class="position-absolute top-0 start-0 bg-dark text-white small fw-semibold px-2 py-0 rounded mt-2 ms-2">
                                    <i data-lucide="video" class="mx-2" style="width: 1rem;"></i> Video
                                </span>

                                <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                    <i data-lucide="play" class="text-white" style="width: 28px; height: 28px;"></i>
                                </div>
                            </div>

                            <!-- Isi Card -->
                            <div class="card-body px-8 py-10 mt-5">
                                <!-- Level & Durasi -->
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge badge-bg-warning text-warning fw-semibold px-3 py-2">Menengah</span>
                                    <span class="text-dark small d-flex align-items-center gap-1">
                                        <i data-lucide="clock" style="width: 14px; height: 14px;"></i> 25 menit
                                    </span>
                                </div>

                                <!-- Judul -->
                                <h5 class="fw-bold mb-3 text-dark">Panduan Lengkap Sengketa Pertanahan</h5>

                                <!-- Deskripsi -->
                                <p class="text-dark mb-3">Tutorial komprehensif menangani sengketa tanah dari A–Z</p>

                                <!-- Rating & Views -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex align-items-center gap-2 text-dark small">
                                        <i data-lucide="star" class="text-warning" style="width: 13px; height: 13px; filter: drop-shadow(0 0 2px rgba(255, 193, 7, 0.6));" fill="currentColor"></i>
                                        <span class="fw-semibold text-dark">4.8</span>
                                        <span>2150 views</span>
                                    </div>

                                    <!-- Tombol -->
                                    <a href="#" class="btn btn-dark rounded-3 px-3 py-2 d-flex align-items-center gap-1">
                                        Baca Panduan
                                        <i data-lucide="arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        {{-- Thumbnail 2 --}}
                        <div class="card bg-light border border-gray-300 overflow-hidden">
                            <div class="position-relative" style="height: 220px; overflow: hidden;">
                                <img src="{{ asset('assets/media/images-guide/documentation-guide.jpg') }}"
                                    class="w-100 h-100 object-fit-cover"
                                    alt="Panduan Sengketa Pertanahan">

                                <span class="position-absolute top-0 start-0 bg-dark text-white small fw-semibold px-2 py-0 rounded mt-2 ms-2">
                                    <i data-lucide="video" class="mx-2" style="width: 1rem;"></i> Video
                                </span>

                                <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                    <i data-lucide="play" class="text-white" style="width: 28px; height: 28px;"></i>
                                </div>
                            </div>

                            <!-- Isi Card -->
                            <div class="card-body px-8 py-10 mt-5">
                                <!-- Level & Durasi -->
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge badge-bg-danger text-danger fw-semibold px-3 py-2">Lanjutan</span>
                                    <span class="text-dark small d-flex align-items-center gap-1">
                                        <i data-lucide="clock" style="width: 14px; height: 14px;"></i> 12 menit
                                    </span>
                                </div>

                                <!-- Judul -->
                                <h5 class="fw-bold mb-3 text-dark">Best Practices Dokumentasi Kasus</h5>

                                <!-- Deskripsi -->
                                <p class="text-dark mb-3">Tips dan trik mendokumentasikan kasus dengan baik</p>

                                <!-- Rating & Views -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex align-items-center gap-2 text-dark small">
                                        <i data-lucide="star" class="text-warning" style="width: 13px; height: 13px; filter: drop-shadow(0 0 2px rgba(255, 193, 7, 0.6));" fill="currentColor"></i>
                                        <span class="fw-semibold text-dark">4.9</span>
                                        <span>1890 views</span>
                                    </div>

                                    <!-- Tombol -->
                                    <a href="#" class="btn btn-dark rounded-3 px-3 py-2 d-flex align-items-center gap-1">
                                        Baca Panduan
                                        <i data-lucide="arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 mt-7">
            <div class="col-lg-12">
                <div class="card bg-light border border-gray-300">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <h6 class="card-title p-0 d-flex align-items-center">
                            <i data-lucide="book-open" class="me-5 text-primary" style="width: 1.5rem;"></i>
                            Panduan Dasar
                        </h6>
                        <p class="fs-6">Memulai menggunakan aplikasi Justisia</p>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="file-text" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Cara Membuat Tiket Pengaduan</h6>
                                            <p class="mb-0 fs-8">Langkah-langkah mengajukan pengaduan baru</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-warning text-warning px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            5 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="video" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Cara Login dan Mengatur Profil</h6>
                                            <p class="mb-0 fs-8">Panduan login dan pengaturan akun</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-warning text-warning px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            3 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="file-text" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Navigasi Dashboard Utama</h6>
                                            <p class="mb-0 fs-8">Memahami layout dan menu aplikasi</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-warning text-warning px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            4 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-7">
            <div class="col-lg-12">
                <div class="card bg-light border border-gray-300">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <h6 class="card-title p-0 d-flex align-items-center">
                            <i data-lucide="file-text" class="me-5 text-success" style="width: 1.5rem;"></i>
                            Sistem Helpdesk
                        </h6>
                        <p class="fs-6">Mengelola tiket dan pengaduan</p>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="video" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Cara Membuat Tiket Pengaduan</h6>
                                            <p class="mb-0 fs-8">Langkah-langkah mengajukan pengaduan baru</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-chocolate px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            8 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="file-text" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Melacak Status Tiket</h6>
                                            <p class="mb-0 fs-8">Monitor progress dan update tiket</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-chocolate px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            6 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="video" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Mengelola Multi-Tiket</h6>
                                            <p class="mb-0 fs-8">Fitur lanjutan untuk multiple tiket</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-chocolate px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            10 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-7">
            <div class="col-lg-12">
                <div class="card bg-light border border-gray-300">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <h6 class="card-title p-0 d-flex align-items-center">
                            <i data-lucide="image" class="me-5" style="color: #ea580c; width: 1.5rem;"></i>
                            Pembatalan Sertifikat
                        </h6>
                        <p class="fs-6">Proses pembatalan dan verifikasi</p>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="video" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Pembatalan Cacat Administrasi</h6>
                                            <p class="mb-0 fs-8">Proses pembatalan karena kesalahan admin</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-chocolate px-3 py-2">Menengah</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            12 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="file-text" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Tindak Lanjut Putusan Pengadilan</h6>
                                            <p class="mb-0 fs-8">Eksekusi pembatalan berdasarkan putusan</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-warning text-warning px-3 py-2">Lanjutan</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            15 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border border-gray-300 px-8 py-15 h-100 d-flex flex-column justify-content-between">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <!-- Ikon tunggal -->
                                        <i data-lucide="video" class="text-dark me-3" style="width: 1.4rem; margin-top: 2px;"></i>

                                        <div class="mb-2">
                                            <h6 class="fw-semibold mb-1">Upload dan Verifikasi Dokumen</h6>
                                            <p class="mb-0 fs-8">Cara mengunggah dokumen pendukung</p>
                                        </div>
                                    </div>

                                    <!-- Footer Info -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge badge-bg-chocolate px-3 py-2">Pemula</span>
                                            <span class="d-inline-flex align-items-center gap-1 text-dark small">
                                            <i data-lucide="clock" style="width: 1rem;"></i>
                                            7 menit
                                        </span>
                                    </div>

                                    <!-- Right: Arrow Icon -->
                                    <i data-lucide="arrow-right" class="text-dark" style="width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-7">
            <div class="col-lg-12">
                <div class="card bg-light border border-gray-300 mb-5">
                    <div class="card-body py-3 mb-5">
                        <form>
                            <div class="border rounded-3 p-10 text-center bg-light" style="cursor: pointer;">
                                <i data-lucide="download" class="mb-3" width="55" height="55"></i>
                                <h3>Unduh Panduan PDF</h3>
                                <p class="mb-2 fs-7">Dapatkan panduan lengkap dalam format PDF untuk dibaca offline</p>

                                <div class="d-flex justify-content-center mt-8">
                                    <button for="fileUpload" class="btn btn-sm btn-hover-primary border bg-dark border-dark text-white fs-6 d-flex align-items-center gap-2">
                                        <i data-lucide="download" width="20" height="20"></i>
                                        <span>Unduh Panduan Lengkap</span>
                                    </button>
                                </div>

                                <input type="file" id="fileUpload" class="d-none" multiple>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</x-default-layout>
