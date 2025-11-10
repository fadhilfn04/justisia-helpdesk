<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/helpdesk.css') }}">

<style>
    .skeleton {
    position: relative;
    overflow: hidden;
    background: #e0e0e0;
    border-radius: 8px;
}
.skeleton::after {
    content: '';
    position: absolute;
    top: 0;
    left: -150px;
    width: 150px;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: loading 1.2s infinite;
}

@keyframes loading {
    100% {
        left: 100%;
    }
}
</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row g-4">

            {{-- Status Tiket --}}
            <div class="col-12">
                <div class="row g-3 row-status-summary">

                </div>
            </div>

            {{-- Filter & Action --}}
            <div class="col-12">
                <div class="py-10 px-5 rounded bg-white border">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-{{ auth()->user()->role->id != 1 ? 2 : 4 }}">
                                <div class="position-relative">
                                    {!! getIcon('magnifier', 'fs-5 position-absolute top-50 start-0 translate-middle-y ms-3 text-dark') !!}
                                    <input type="text" class="form-control ps-12" id="searchTiket" placeholder="Cari tiket, ID, atau pelapor...">
                                </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select text-dark" id="statusSelect">

                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select text-dark" id="prioritasSelect">

                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select text-dark">
                                <option selected>Semua Wilayah</option>
                                <option value="jakarta_selatan">Jakarta Selatan</option>
                                <option value="bandung">Bandung</option>
                                <option value="surabaya">Surabaya</option>
                                <option value="medan">Medan</option>
                                <option value="makassar">Makassar</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn bg-white border border-gray-300 w-100 btn-hover-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                <i class="fas fa-download me-1"></i> Export Data
                            </button>
                        </div>
                        @if (auth()->user()->role->id != '1')
                            <div class="col-md-2">
                                <button class="btn btn-dark w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createTiketModal">
                                    <i class="fas fa-plus me-1"></i> Buat Tiket Baru
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Daftar Tiket --}}
            <div class="col-12">
                <div class="p-10 rounded border bg-white">
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold mb-1">Daftar Tiket (5)</h4>
                                <p class="text-muted mb-0 fs-7">Kelola dan pantau semua tiket helpdesk</p>
                            </div>
                            <button class="btn btn-sm bg-white border border-gray-300 btn-hover-primary" id="btnRefreshTabel">
                                <i data-lucide="refresh-cw" class="me-2" width="16" height="16"></i> Refresh Tabel
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tabel-tiket" class="table bg-white table-border-bottom-only fs-6-5" style="min-width: 1435px;">
                            <thead class="fw-semibold">
                                <tr>
                                    <th style="width: 8%;">ID Tiket</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Pelapor</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Wilayah</th>
                                    <th>SLA</th>
                                    <th>Respon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- modal export data --}}
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-start border-0">
                <div class="d-flex align-items-center mb-1">
                    <i data-lucide="arrow-down-to-line" class="me-2" style="width: 1.5rem;"></i>
                    <h5 class="modal-title mb-0" id="exportModalLabel">Export Data Helpdesk</h5>
                </div>
                <span class="small fs-7">Konfigurasi pengaturan export untuk laporan data helpdesk</span>
                <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="mb-7">
                    <label class="fw-semibold text-dark mb-2 d-block">Format Export</label>
                    <div class="d-flex align-items-center gap-4">
                    <div class="form-check">
                        <input class="form-check-input form-check-sm" type="radio" name="exportFormat" id="exportExcel" checked>
                        <label class="form-check-label d-flex align-items-center text-dark" for="exportExcel">
                        <i data-lucide="file-text" style="width: 1.4rem;" class="me-2"></i> Excel (CSV)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input form-check-sm" type="radio" name="exportFormat" id="exportPdf">
                        <label class="form-check-label d-flex align-items-center text-dark" for="exportPdf">
                        <i data-lucide="file-text" style="width: 1.4rem;" class="me-2"></i> PDF
                        </label>
                    </div>
                    </div>
                </div>

                <hr class="my-3" style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                <div class="mb-7">
                    <label class="fw-semibold text-dark mb-2 d-block">Rentang Tanggal</label>
                    <div class="d-flex gap-3">
                    <button class="btn border border-gray-300 w-30 d-flex py-2 align-items-center justify-content-start gap-4 btn-hover-primary">
                        <i data-lucide="calendar" style="width: 1.4rem;"></i> Dari tanggal
                    </button>
                    <button class="btn border border-gray-300 w-30 d-flex py-2 align-items-center justify-content-start gap-4 btn-hover-primary">
                        <i data-lucide="calendar" style="width: 1.4rem;"></i> Sampai tanggal
                    </button>
                    </div>
                </div>

                <hr class="my-3" style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                <div class="row g-3 mb-5">
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1">Status</label>
                        <select class="form-select shadow-none border">
                            <option>Semua Status</option>
                            <option>Pending</option>
                            <option>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1">Prioritas</label>
                        <select class="form-select shadow-none border">
                            <option>Semua Prioritas</option>
                            <option>Tinggi</option>
                            <option>Rendah</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1">Wilayah</label>
                        <select class="form-select shadow-none border">
                            <option>Semua Wilayah</option>
                            <option>Jakarta</option>
                            <option>Bandung</option>
                        </select>
                    </div>
                </div>

                <hr class="my-3" style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                <div class="mb-5">
                    <label class="fw-semibold text-dark mb-2 d-block">Data Yang Disertakan</label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input form-check-input-dark" type="checkbox" id="dataDasar" checked>
                                <label class="form-check-label text-dark" for="dataDasar">Informasi Dasar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input-dark" type="checkbox" id="dataRespon" checked>
                                <label class="form-check-label text-dark" for="dataRespon">Detail Respon</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input form-check-input-dark" type="checkbox" id="dataAktivitas" checked>
                                <label class="form-check-label text-dark" for="dataAktivitas">Timeline Aktivitas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input-dark" type="checkbox" id="dataLampiran" checked>
                                <label class="form-check-label text-dark" for="dataLampiran">Daftar Lampiran</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-3" style="border: 0; border-top: 1px solid var(--bs-gray-600);">

                <div class="mb-5">
                    <div class="d-flex align-items-center mb-2">
                        <i data-lucide="filter" class="me-2 text-dark" style="width: 1.1rem;"></i>
                        <h6 class="fw-semibold mb-0">Ringkasan Export</h6>
                    </div>
                    <div class="ms-4">
                        <div class="mb-1">Format:
                        <span class="badge bg-light text-dark border border-gray-300">EXCEL</span>
                        </div>
                        <div>Total data yang akan diexport: <span class="fw-semibold">5 tiket</span></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" class="btn bg-white border border-gray-300 btn-hover-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-dark">
                        <i data-lucide="download" class="me-2" style="width: 1.2rem;"></i> Export EXCEL
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailTiket" tabindex="-1" aria-labelledby="detailTiketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_detail_tiket_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Detail Tiket</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>

            <!-- Body -->
            <div class="modal-body p-5">
                <div id="detail-tiket-content">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="fw-semibold text-gray-700">Judul Tiket</label>
                            <div id="tiket-judul" class="fw-bold fs-6 text-dark"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold text-gray-700">Kategori</label>
                            <div id="tiket-kategori" class="text-dark"></div>
                        </div>

                        <div class="col-12">
                            <label class="fw-semibold text-gray-700">Deskripsi</label>
                            <div id="tiket-deskripsi" class="text-muted"></div>
                        </div>

                        <div class="col-12">
                            <label class="fw-semibold text-gray-700">Lampiran</label>
                            <div id="tiket-lampiran" class="border p-3 rounded bg-light"></div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <!-- Pilih Prioritas -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="fw-semibold text-gray-700">Prioritas</label>
                            <select id="prioritas" class="form-select form-select-solid">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-gray-700">Pilih Agent</label>
                            <select id="agent_id" class="form-select form-select-solid">
                                <option value="">-- Pilih Agent --</option>
                                @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 d-flex justify-content-between px-5 pb-4">
                <button type="button" class="btn btn-light-danger" id="btn-return">
                    <i data-lucide="rotate-ccw" class="me-1"></i> Kembalikan ke Pengguna
                </button>

                <button type="button" class="btn btn-light-success" id="btn-verifikasi-final">
                    <i data-lucide="check-circle" class="me-1"></i> Verifikasi & Tugaskan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- modal buat tiket baru --}}
<div class="modal fade" id="createTiketModal" tabindex="-1" aria-labelledby="createTiketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 850px;">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-start border-0">
                <div class="d-flex align-items-center mb-1">
                    <i data-lucide="ticket" class="me-2" style="width: 1.8rem;"></i>
                    <h3 class="modal-title mb-0" id="createTiketModalLabel">Buat Tiket</h3>
                </div>
                <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-2">
                <form id="formTiket" enctype="multipart/form-data">
                    @csrf
                    {{-- user id --}}
                    <input type="hidden" name="tiketId" class="tiket-id">
                    <input type="hidden" name="userPelaporId" class="user-pelapor-id" value="{{ auth()->user()->id }}">

                    <div class="mx-auto" style="max-width: 900px;">
                        <!-- Card FAQ Header -->
                        <div class="card border mb-4 border-gray-300">
                            <div class="py-3">
                                <div class="d-flex justify-content-start mx-5 align-items-center gap-3">
                                    <i data-lucide="circle-alert" class="text-dark" style="width: 1.3rem;;"></i>
                                    <span class="text-dark mb-0">Pastikan semua informasi yang Anda berikan akurat dan lengkap untuk mempercepat proses penanganan.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-5">
                            <!-- 🧭 Kiri: Kontak dan Form -->
                            <div class="col-lg-{{ auth()->user()->role->id != 3 ? 8 : 12 }}">
                                <!-- 1️⃣ Saluran Kontak Resmi -->
                                <div class="card mb-5 border border-gray-300">
                                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                                        <span class="card-title p-0 d-flex align-items-center">
                                            Informasi Tiket
                                        </span>
                                        <p class="py-0">Berikan detail lengkap mengenai masalah yang Anda hadapi</p>
                                    </div>
                                    <div class="card-body py-3 mb-5">
                                        <div class="mb-4">
                                            <label for="judul" class="form-label fw-semibold">Judul Tiket <span class="text-dark">*</span></label>
                                            <input type="text" id="judul" class="form-control fs-6" name="title" placeholder="Ringkasan singkat masalah Anda" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Detail <span class="text-dark">*</span></label>
                                            <textarea id="deskripsi" class="form-control fs-6" name="deskripsi" rows="2" placeholder="Jelaskan masalah Anda secara detail, termasuk kronologi dan dampak yang terjadi" required></textarea>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-8">
                                                <label for="kategori" class="form-label fw-semibold">Kategori <span class="text-dark">*</span></label>
                                                <select id="kategori" class="form-select fs-6" style="width: 100%;" name="kategori" required>

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
                                    </div>
                                </div>

                                <div class="card mb-5 border border-gray-300">
                                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                                        <span class="card-title p-0 d-flex align-items-center">
                                            Data Pelapor
                                        </span>
                                        <p class="py-0">Informasi kontak untuk komunikasi dan update tiket</p>
                                    </div>
                                    <div class="card-body py-3 mb-5">
                                        <div class="mb-4">
                                            <label for="nama_lengkap" class="form-label fw-semibold">Nama lengkap<span class="text-dark">*</span></label>
                                            <input type="text" id="nama_lengkap" class="form-control fs-6" value="{{ auth()->user()->name }}" disabled>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label fw-semibold">Email <span class="text-dark">*</span></label>
                                                <input id="email" class="form-control fs-6" value="{{ auth()->user()->email }}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="no_telepon" class="form-label fw-semibold">No Telepon <span class="text-dark">*</span></label>
                                                <input id="no_telepon" class="form-control fs-6" value="{{ auth()->user()->phone }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-5 border border-gray-300">
                                    <div class="card-header d-flex mt-5 border-0 flex-column align-items-start">
                                        <span class="card-title p-0 d-flex align-items-center">
                                            Lampiran Dokumen
                                        </span>
                                        <p class="py-0">
                                            Upload dokumen pendukung (maksimal 10MB per file). Format: JPG, JPEG, PNG, PDF.
                                        </p>
                                    </div>
                                    <div class="card-body py-3 mb-5">
                                        <div class="filepond-wrapper" style="padding: 2rem 1rem;">
                                            <input type="file" id="fileUpload" name="fileTiket[]" accept=".jpg,.jpeg,.png,.pdf" required/>
                                            <div id="previewArea" class="mt-5"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->role->id != '3')
                                <div class="col-lg-4">
                                    <div class="card border mb-3 border-gray-300">
                                        <div class="card-header border-0">
                                            <h1 class="card-title" style="font-size: 1.2rem; font-weight: 600;">
                                                Prioritas
                                            </h1>
                                        </div>

                                        <div class="card-body py-0 mb-2">
                                            <div class="priority-option text-danger fs-6 fw-semibold" data-value="high">Tinggi</div>
                                            <div class="priority-option text-warning fs-6 fw-semibold active" data-value="medium">Sedang</div>
                                            <div class="priority-option text-success fs-6 fw-semibold" data-value="low">Rendah</div>
                                        </div>
                                    </div>

                                    <!-- Card Estimasi SLA -->
                                    <div class="card border mb-3 border-gray-300">
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
                                </div>
                            @endif
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2">
                <button class="btn border border-gray-300 btn-hover-primary py-2 fw-semibold bg-white" id="btnDraftTiket">Simpan Draft</button>
                <button class="btn btn-dark py-2 fw-semibold" id="btnCreateTiket">Buat Tiket</button>
                <button class="btn btn-dark py-2 fw-semibold" id="btnEditTiket">Edit Tiket</button>
                <button class="btn border border-gray-300 btn-hover-primary py-2 fw-semibold bg-white" id="btnTolakTiket">Tolak Tiket</button>
                <button class="btn btn-dark py-2 fw-semibold" id="btnTerimaTiket">Terima Tiket</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="responModal" tabindex="-1" aria-labelledby="responModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 850px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responModalLabel">Diskusi terkait tiket dengan agen Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Card Chat -->
                <div class="card border-0" style="height: 500px;">
                    <div class="card-body d-flex flex-column p-0">
                        <!-- Area pesan -->
                        <div id="chatArea" class="flex-grow-1 overflow-auto p-4" style="background: #f8f9fa;"></div>

                        <div class="border-top p-3 bg-white d-flex align-items-center justify-content-between gap-2 input-chat-wrapper">
                            <div class="flex-grow-1"">
                                <input
                                    type="text"
                                    id="chatInput"
                                    class="form-control px-3 py-2"
                                    placeholder="Ketik pesan..."
                                    style="border-radius: 30px; border: 1px solid #ddd;"
                                />
                            </div>

                            <button
                                id="sendBtn"
                                class="btn btn-chat-send d-flex align-items-center justify-content-center"
                                style="width: 38px; height: 38px; border-radius: 50%; color: white;">
                                <i class="fa-solid fa-paper-plane" style="font-size: 1.1rem; color: inherit;"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('assets/js/custom-js/helpdesk.js') }}"></script>
@endpush

</x-default-layout>
