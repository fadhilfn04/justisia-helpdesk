<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/helpdesk.css') }}">

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row g-4">

            {{-- Status Tiket --}}
            <div class="col-12">
                <div class="row g-3">
                    @php
                        $statuses = [
                            ['label' => 'Semua Tiket', 'count' => 5, 'color' => 'text-dark'],
                            ['label' => 'Terbuka', 'count' => 1, 'color' => 'text-primary'],
                            ['label' => 'Proses', 'count' => 1, 'color' => 'text-warning'],
                            ['label' => 'Menunggu', 'count' => 1, 'color' => 'text-orange'],
                            ['label' => 'Selesai', 'count' => 1, 'color' => 'text-success'],
                            ['label' => 'Terlambat', 'count' => 1, 'color' => 'text-danger'],
                        ];
                    @endphp

                    @foreach ($statuses as $status)
                        <div class="col-md-2 col-6">
                            <div class="card h-100 card-index-helpdesk rounded border p-12 text-center"
                            data-status="{{ strtolower($status['label']) }}">
                                <div class="fw-bold fs-1 {{ $status['color'] }}">{{ $status['count'] }}</div>
                                <div class="fs-7 small">{{ $status['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Filter & Action --}}
            <div class="col-12">
                <div class="py-10 px-5 rounded bg-white border">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-2">
                            <div class="position-relative">
                                {!! getIcon('magnifier', 'fs-5 position-absolute top-50 start-0 translate-middle-y ms-3 text-dark') !!}
                                <input type="text" class="form-control ps-12" placeholder="Cari tiket, ID, atau pelapor...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select text-dark">
                                <option selected>Semua Status</option>
                                <option value="terbuka">Terbuka</option>
                                <option value="proses">Proses</option>
                                <option value="menunggu">Menungggu</option>
                                <option value="selesai">Selesai</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select text-dark">
                                <option selected>Semua Prioritas</option>
                                <option value="tinggi">Tinggi</option>
                                <option value="sedang">Sedang</option>
                                <option value="rendah">Rendah</option>
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
                        <div class="col-md-4 d-flex gap-4 justify-content-end">
                            <button class="btn bg-white border border-gray-300 w-100 btn-hover-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                <i class="fas fa-download me-1"></i> Export Data
                            </button>
                            <button class="btn btn-dark w-100">
                                <i class="fas fa-plus me-1"></i> Buat Tiket Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Tiket --}}
            <div class="col-12">
                <div class="p-10 rounded border bg-white">
                    <div class="mb-5">
                        <h4 class="fw-bold mb-1">Daftar Tiket (5)</h4>
                        <p class="text-muted mb-0 fs-7">Kelola dan pantau semua tiket helpdesk</p>
                    </div>

                    <div class="table-responsive">
                        <table id="tabel-tiket" class="table bg-white table-border-bottom-only fs-6-5" style="min-width: 1335px;">
                            <thead class="fw-semibold">
                                <tr>
                                    <th style="width: 12%;">ID Tiket</th>
                                    <th style="width: 25%;">Judul</th>
                                    <th style="width: 5%;">Status</th>
                                    <th style="width: 5%;">Prioritas</th>
                                    <th style="width: 12%;">Pelapor</th>
                                    <th style="width: 16%;">Penanggung Jawab</th>
                                    <th style="width: 15%;">Wilayah</th>
                                    <th style="width: 10%;">SLA</th>
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

@push('scripts')
    <script src="{{ asset('assets/js/custom-js/helpdesk.js') }}"></script>
@endpush

</x-default-layout>
