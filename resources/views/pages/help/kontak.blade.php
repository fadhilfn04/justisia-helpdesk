<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/help.css') }}">

<div class="content-wrapper">
    <header class="d-flex align-items-center gap-3 py-4 px-4">
        <div class="bg-light border d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
            <i data-lucide="message-square" class="text-dark" style="font-size: 2.5rem;"></i>
        </div>
        <div>
            <h1 class="h1 mb-1">Pusat Bantuan ATR/BPN</h1>
            <p class="mb-0 fs-6">Hubungi kami untuk mendapatkan bantuan terkait layanan pertanahan</p>
        </div>
    </header>

    <div class="container py-7">
        <div class="row g-5">
            <!-- 🧭 Kiri: Kontak dan Form -->
            <div class="col-lg-8">
                <!-- 1️⃣ Saluran Kontak Resmi -->
                <div class="card mb-5 border">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <h5 class="card-title p-0 d-flex align-items-center">
                            <i data-lucide="phone" class="mx-2" style="width: 1.5rem;"></i>
                            Saluran Kontak Resmi
                        </h5>
                        <p>Pilih saluran komunikasi yang sesuai dengan kebutuhan Anda</p>
                    </div>
                    <div class="card-body">
                        <!-- Email -->
                        <div class="p-5 mb-3 rounded border border-gray-300 card-hover">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 bg-white rounded text-primary">
                                    <i data-lucide="mail" style="width: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="fw-semibold mb-1">
                                        Email Resmi <span class="badge bg-primary text-white fs-7 ms-2">1-2 hari kerja</span>
                                    </h4>
                                    <p class="fs-7 mb-2">Untuk pertanyaan umum dan pengaduan</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-medium mb-1">mitra@atrbpn.go.id</div>
                                            <div class="small"><i class="far fa-clock me-1 fs-8 text-dark"></i>24/7</div>
                                        </div>
                                        <a href="mailto:mitra@atrbpn.go.id?subject=Pertanyaan%20Umum&body=Halo%2C%20saya%20ingin%20bertanya%20tentang..."
                                            class="btn bg-white border btn-sm btn-hover-primary">
                                            Hubungi <i class="fas fa-external-link-alt ms-2 fs-7 text-dark"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call Center -->
                        <div class="p-5 mb-3 rounded border border-gray-300 card-hover">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 bg-white rounded text-success">
                                    <i data-lucide="phone" style="width: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="fw-semibold mb-1">
                                        Call Center <span class="badge bg-primary text-white fs-7 ms-2">Langsung</span>
                                    </h4>
                                    <p class="fs-7 mb-2">Bantuan langsung via telepon</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-medium mb-1">14000 (Mandiri Call)</div>
                                            <div class="small"><i class="far fa-clock me-2 fs-7 text-dark"></i>Senin–Jumat, 08:00–16:00</div>
                                        </div>
                                        <a href="tel:14000" class="btn bg-white border btn-sm btn-hover-primary">
                                            Hubungi <i class="fas fa-external-link-alt ms-2 fs-7 text-dark"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kantor -->
                        <div class="p-5 mb-3 rounded border border-gray-300 card-hover">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 bg-white rounded text-danger">
                                    <i data-lucide="building-2" style="width: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="fw-semibold mb-1">
                                        Kantor Pusat <span class="badge bg-primary text-white fs-7 ms-2">Langsung</span>
                                    </h4>
                                    <p class="fs-7 small mb-2">Kunjungan langsung ke kantor</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-medium mb-1">Jl. Sisingamangaraja No.2, Jakarta Selatan</div>
                                            <div class="small"><i class="far fa-clock me-2 fs-7 text-dark"></i>Senin–Jumat, 08:00–16:00</div>
                                        </div>
                                        <a href="https://maps.google.com/?q=Jl. Sisingamangaraja No.2, Jakarta Selatan" 
                                            target="_blank"
                                            class="btn bg-white border btn-sm btn-hover-primary">
                                            Hubungi <i class="fas fa-external-link-alt ms-2 fs-7 text-dark"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Helpdesk -->
                        <div class="p-5 rounded border border-gray-300 card-hover">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 bg-white rounded text-primary">
                                    <i data-lucide="message-square" style="width: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="fw-semibold mb-1">
                                        Helpdesk Internal <span class="badge bg-primary text-white fs-7 ms-2">2–4 jam</span>
                                    </h4>
                                    <p class="fs-7 mb-2">Sistem tiket internal Justisia</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-medium mb-1">Buat tiket baru</div>
                                            <div class="small"><i class="far fa-clock me-2 fs-7 text-dark"></i>24/7</div>
                                        </div>
                                        <a href="{{ route('tiket.index') }}">
                                            <button class="btn bg-white border btn-sm btn-hover-primary">
                                                Buat Tiket 
                                                <i class="fas fa-external-link-alt ms-2 fs-7 text-dark"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🧱 Kanan: Info, FAQ, Sosmed, Darurat -->
            <div class="col-lg-4">
                <!-- Informasi Kantor -->
                <div class="card mb-4">
                    <div class="card-header border-0">
                        <h1 class="card-title" style="font-size: 1.4rem; font-weight: 600;">
                            <i data-lucide="building-2" class="me-2" style="width: 1.5rem;"></i>
                            Informasi Kantor
                        </h1>
                    </div>
                    <div class="card-body py-3 mb-5">
                        <div class="d-flex align-items-start mb-4">
                            <i data-lucide="map-pin" class="me-3 text-dark" style="width: 1.2rem; height: 1.2rem;"></i>
                            <p class="mb-0 fs-6">
                                Alamat:<br>
                                Jl. Sisingamangaraja No.2<br>
                                Jakarta Selatan 12110
                            </p>
                        </div>
                        <hr style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                        <div class="d-flex align-items-start mb-4">
                            <i data-lucide="clock" class="me-3 text-dark" style="width: 1.2rem; height: 1.2rem;"></i>
                            <p class="mb-0 fs-6">
                                Jam Operasional:<br>
                                Senin - Jumat<br>
                                08:00 - 16:00 WIB
                            </p>
                        </div>
                        <hr style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                        <div class="d-flex align-items-start">
                            <i data-lucide="mail" class="me-3 text-dark" style="width: 1.2rem; height: 1.2rem;"></i>
                            <p class="mb-0 fs-6">
                                Email:<br>
                                mitra@atrbpn.go.id
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="card mb-4 border">
                    <div class="card-header border-0">
                        <h1 class="card-title mb-1" style="font-size: 1.4rem; font-weight: 600;">
                            <i data-lucide="globe" class="me-2" style="width: 1.5rem;"></i> Media Sosial
                        </h1>
                    </div>

                    <div class="card-body py-3 mb-5">
                        <div class="row g-2">

                            <!-- Facebook -->
                            <div class="col-6">
                                <a href="https://facebook.com/atrbpn" target="_blank"
                                class="btn border border-gray-300 w-100 fs-6-5 d-flex justify-content-start align-items-center px-3 py-1">
                                    <i data-lucide="facebook" class="text-dark me-4" style="width: 1.2rem;"></i>
                                    <span>Facebook</span>
                                </a>
                            </div>

                            <!-- Twitter / X -->
                            <div class="col-6">
                                <a href="https://twitter.com/atrbpn" target="_blank"
                                class="btn border border-gray-300 w-100 fs-6-5 d-flex justify-content-start align-items-center px-3 py-1">
                                    <i data-lucide="twitter" class="text-dark me-4" style="width: 1.2rem;"></i>
                                    <span>Twitter</span>
                                </a>
                            </div>

                            <!-- Instagram -->
                            <div class="col-6">
                                <a href="https://instagram.com/atrbpn" target="_blank"
                                class="btn border border-gray-300 w-100 fs-6-5 d-flex justify-content-start align-items-center px-3 py-1">
                                    <i data-lucide="instagram" class="text-dark me-4" style="width: 1.2rem;"></i>
                                    <span>Instagram</span>
                                </a>
                            </div>

                            <!-- YouTube -->
                            <div class="col-6">
                                <a href="https://youtube.com/atrbpn" target="_blank"
                                class="btn border border-gray-300 w-100 fs-6-5 d-flex justify-content-start align-items-center px-3 py-1">
                                    <i data-lucide="youtube" class="text-dark me-4" style="width: 1.2rem;"></i>
                                    <span>YouTube</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="card border">
                    <div class="card-header border-0">
                        <h1 class="card-title mb-1" style="font-size: 1.4rem; font-weight: 600;"><i data-lucide="circle-alert" class="me-2" style="width: 1.5rem;"></i> Kontak Darurat</h1>
                    </div>
                    <div class="card-body py-3 mb-5">
                        <span class="text-danger fs-6-5">Untuk kasus mendesak yang memerlukan penanganan segera, hubungi hotline darurat:</span>
                        <div class="fw-bold mt-2 fs-4 text-danger">📞 14000 (24 jam)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-default-layout>
