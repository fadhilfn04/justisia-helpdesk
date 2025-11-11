<x-default-layout>

    @section('title')
        Laporan & Analitik
    @endsection

    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('reports.index') }}
    @endsection --}}

    <div class="card">
        <div class="card-body">
            <!-- Filter dan Tombol Ekspor -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-8">
                <div class="d-flex gap-3 mt-5 mt-md-0">
                    <select class="form-select w-150px">
                        <option>Bulanan</option>
                        <option>Triwulanan</option>
                        <option>Tahunan</option>
                    </select>

                    <select class="form-select w-180px">
                        <option>Semua Wilayah</option>
                        <option>Jakarta</option>
                        <option>Bandung</option>
                        <option>Makassar</option>
                    </select>

                    <select class="form-select w-180px">
                        <option>Semua Kategori</option>
                        <option>Sengketa Batas</option>
                        <option>Konflik Kepemilikan</option>
                        <option>Cacat Administrasi</option>
                        <option>Putusan Pengadilan</option>
                    </select>
                </div>

                <div class="d-flex gap-3 mt-5 mt-md-0">
                    <button class="btn btn-light">
                        <i class="ki-outline ki-exit-up fs-3"></i> Export Excel
                    </button>
                    <button class="btn btn-light">
                        <i class="ki-outline ki-file fs-3"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-line-tabs mb-6 fs-6">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_overview">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_kinerja">Kinerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_regional">Regional</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_tren">Tren</a>
                </li>
            </ul>

            <div class="tab-content" id="reportTabs">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="tab_overview" role="tabpanel">

                    @include('partials.dashboard.cards._statistik-kinerja')

                    <div class="row">
                        <div class="col-md-8 mb-6">
                            @include('partials.dashboard.charts._kinerja-bulanan')
                        </div>

                        <div class="col-md-4 mb-6">
                            @include('partials.dashboard.charts._distribusi-kategori')
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="tab_kinerja" role="tabpanel">

                    @include('partials.dashboard.tables._kinerja-agen')
                    @include('partials.dashboard.charts._tren-sla')
                </div>

                <div class="tab-pane fade" id="tab_regional" role="tabpanel">
                    @include('partials.dashboard.charts._kinerja-regional')
                </div>

                <div class="tab-pane fade" id="tab_tren" role="tabpanel">
                    @include('partials.dashboard.charts._tren-tiket-harian')
                </div>
            </div>
        </div>
    </div>

</x-default-layout>