<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/helpdesk.css') }}">

<div class="container">
    <div class="mx-auto" style="max-width: 900px;">
        <!-- Card FAQ Header -->
        <div class="card border mb-4">
            <div class="py-3">
                <div class="d-flex justify-content-start mx-5 align-items-center gap-3">
                    <i data-lucide="circle-alert" class="text-dark" style="width: 1.3rem;;"></i>
                    <span class="text-dark mb-0">Pastikan semua informasi yang Anda berikan akurat dan lengkap untuk mempercepat proses penanganan.</span>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- 🧭 Kiri: Kontak dan Form -->
            <div class="col-lg-8">
                <!-- 1️⃣ Saluran Kontak Resmi -->
                <div class="card mb-5 border">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <span class="card-title p-0 d-flex align-items-center">
                            Informasi Tiket
                        </span>
                        <p class="py-0">Berikan detail lengkap mengenai masalah yang Anda hadapi</p>
                    </div>
                    <div class="card-body py-3 mb-5">
                        <form>
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">Judul Tiket <span class="text-dark">*</span></label>
                                <input type="text" id="judul" class="form-control fs-6" placeholder="Ringkasan singkat masalah Anda">
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi Detail <span class="text-dark">*</span></label>
                                <textarea id="deskripsi" class="form-control fs-6" rows="2" placeholder="Jelaskan masalah Anda secara detail, termasuk kronologi dan dampak yang terjadi"></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-semibold">Kategori <span class="text-dark">*</span></label>
                                    <select id="kategori" class="form-select fs-6">
                                        <option selected disabled>Pilih kategori masalah</option>
                                        <option value="sengketa-batas">Sengketa Batas</option>
                                        <option value="konflik-kepemilikan">Konflik Kepemilikan</option>
                                        <option value="cacat-administrasi">Cacat Administrasi</option>
                                        <option value="putusan-pengadilan">Putusan Pengadilan</option>
                                        <option value="verifikasi-dokumen">Verifikasi Dokumen</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <!-- Wilayah -->
                                <div class="col-md-4">
                                    <label for="wilayah" class="form-label fw-semibold">Wilayah <span class="text-dark">*</span></label>
                                    <select id="wilayah" class="form-select fs-6">
                                        <option selected disabled>Pilih wilayah</option>
                                        <option value="jakarta-pusat">Jakarta Pusat</option>
                                        <option value="jakarta-selatan">Jakarta Selatan</option>
                                        <option value="jakarta-timur">Jakarta Timur</option>
                                        <option value="jakarta-barat">Jakarta Barat</option>
                                        <option value="jakarta-utara">Jakarta Utara</option>
                                        <option value="bandung">Bandung</option>
                                        <option value="surabaya">Surabaya</option>
                                        <option value="medan">Medan</option>
                                        <option value="makassar">Makassar</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-5 border">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <span class="card-title p-0 d-flex align-items-center">
                            Data Pelapor
                        </span>
                        <p class="py-0">Informasi kontak untuk komunikasi dan update tiket</p>
                    </div>
                    <div class="card-body py-3 mb-5">
                        <form>
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">Nama lengkap<span class="text-dark">*</span></label>
                                <input type="text" id="judul" class="form-control fs-6" placeholder="Nama Lengkap Pelapor">
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="deskripsi" class="form-label fw-semibold">Email <span class="text-dark">*</span></label>
                                    <input id="deskripsi" class="form-control fs-6" placeholder="email@example.com"></input>
                                </div>

                                <div class="col-md-6">
                                    <label for="deskripsi" class="form-label fw-semibold">Email <span class="text-dark">*</span></label>
                                    <input id="deskripsi" class="form-control fs-6" placeholder="08xxxxxxxxxx"></input>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-5 border">
                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                        <span class="card-title p-0 d-flex align-items-center">
                            Lampiran Dokumen
                        </span>
                        <p class="py-0">Upload dokumen pendukung (maksimal 10MB per file)</p>
                    </div>
                    <div class="card-body py-3 mb-5">
                        <form>
                            <div class="border border-dashed border-gray-400 rounded-3 p-10 text-center"
                                style="cursor: pointer;">
                                <i data-lucide="download" class="mb-3" width="35" height="35"></i>
                                <p class="mb-2 fs-7">Drag & drop files atau klik untuk upload</p>
                                <label for="fileUpload" class="btn btn-sm btn-hover-primary border bg-white border-gray-300">
                                    Pilih File
                                </label>
                                <input type="file" id="fileUpload" class="d-none" multiple>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if(auth()->user()->role->id != '3')
                    <div class="card border mb-3">
                        <div class="card-header border-0">
                            <h1 class="card-title" style="font-size: 1.2rem; font-weight: 600;">
                                Prioritas
                            </h1>
                        </div>

                        <div class="card-body py-0 mb-2">
                            <div class="priority-option text-danger fs-6 fw-semibold" data-value="tinggi">Tinggi</div>
                            <div class="priority-option text-warning fs-6 fw-semibold active" data-value="sedang">Sedang</div>
                            <div class="priority-option text-success fs-6 fw-semibold" data-value="rendah">Rendah</div>
                        </div>
                    </div>
                @endif

                <!-- Card Opsi Tambahan -->
                <div class="card border mb-3">
                    <div class="card-header border-0">
                        <h1 class="card-title" style="font-size: 1.2rem; font-weight: 600;">Opsi Tambahan</h1>
                    </div>
                    <div class="card-body py-0 mb-5">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input form-check-input-dark me-2" type="checkbox" id="kasusMendesak" checked>
                            <label class="form-check-label text-dark fw-bold" for="kasusMendesak">
                                Kasus mendesak (memerlukan penanganan segera)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card Estimasi SLA -->
                <div class="card border mb-3">
                    <div class="card-header border-0">
                        <h1 class="card-title" style="font-size: 1.2rem; font-weight: 600;">Estimasi SLA</h1>
                    </div>
                    <div class="card-body py-0 mb-5 text-dark">
                        <span class="fw-semibold">Berdasarkan kategori dan prioritas:</span>
                        <ul class="mt-2 mb-0 ps-3">
                            <li>Respon awal: <span class="fw-bold text-dark">3x24 jam</span></li>
                            <li>Penyelesaian: <span class="fw-bold text-dark">7–14 hari kerja</span></li>
                        </ul>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-grid gap-2">
                    <button class="btn btn-dark py-2 fw-semibold">Buat Tiket</button>
                    <button class="btn border border-gray-300 btn-hover-primary py-2 fw-semibold bg-white">Simpan Draft</button>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/custom-js/helpdesk.js') }}"></script>
@endpush
</x-default-layout>
