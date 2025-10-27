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

                    <!-- Statistik Kinerja -->
                    <div class="row mb-8">
                        <div class="col-md-3">
                            <div class="bg-light rounded-3 p-6 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-6 text-gray-600">Total Tiket</span>
                                    <i class="ki-outline ki-graph fs-2 text-gray-500"></i>
                                </div>
                                <div class="fs-2hx fw-bold text-gray-800">1,247</div>
                                <div class="fs-7 text-success mt-2">
                                    +12% <span class="text-gray-600">dari periode sebelumnya</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-light rounded-3 p-6 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-6 text-gray-600">Tingkat Penyelesaian</span>
                                    <i class="ki-outline ki-chart-line-up fs-2 text-gray-500"></i>
                                </div>
                                <div class="fs-2hx fw-bold text-gray-800">87.5%</div>
                                <div class="fs-7 text-success mt-2">
                                    +2.1% <span class="text-gray-600">dari periode sebelumnya</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-light rounded-3 p-6 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-6 text-gray-600">Rata-rata Waktu Respon</span>
                                    <i class="ki-outline ki-calendar fs-2 text-gray-500"></i>
                                </div>
                                <div class="fs-2hx fw-bold text-gray-800">2.8 <span class="fs-3">hari</span></div>
                                <div class="fs-7 text-danger mt-2">
                                    -0.3 hari <span class="text-gray-600">dari periode sebelumnya</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-light rounded-3 p-6 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-6 text-gray-600">SLA Compliance</span>
                                    <i class="ki-outline ki-time fs-2 text-gray-500"></i>
                                </div>
                                <div class="fs-2hx fw-bold text-gray-800">89.2%</div>
                                <div class="fs-7 text-success mt-2">
                                    +1.5% <span class="text-gray-600">dari periode sebelumnya</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik & Distribusi -->
                    <div class="row">
                        <div class="col-md-8 mb-6">
                            @include('partials.dashboard.charts._kinerja-bulanan')
                        </div>

                        <div class="col-md-4 mb-6">
                            @include('partials.dashboard.charts._distribusi_kategori')
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="tab_kinerja" role="tabpanel">
                    <div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
                        <h4 class="fw-bold mb-1">Kinerja Agen</h4>
                        <p class="text-muted mb-4">Performa individual agen helpdesk</p>

                        @php
                            $agents = [
                                ['name' => 'Ahmad Fauzi', 'tickets' => 45, 'response' => 2.5, 'rating' => 4.8],
                                ['name' => 'Dewi Sartika', 'tickets' => 38, 'response' => 3.2, 'rating' => 4.6],
                                ['name' => 'Rina Susanti', 'tickets' => 42, 'response' => 2.8, 'rating' => 4.7],
                                ['name' => 'Bambang Sutrisno', 'tickets' => 35, 'response' => 3.5, 'rating' => 4.4],
                                ['name' => 'Sari Indah', 'tickets' => 28, 'response' => 4.1, 'rating' => 4.2],
                            ];
                        @endphp

                        <div class="space-y-3">
                            @foreach ($agents as $agent)
                                @php
                                    $initials = collect(explode(' ', $agent['name']))->map(fn($n) => strtoupper($n[0]))->join('');
                                @endphp

                                <div class="d-flex align-items-center justify-content-between border rounded-3 p-3 hover:bg-gray-50 transition">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-weight: 600;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $agent['name'] }}</div>
                                            <div class="text-muted small">{{ $agent['tickets'] }} tiket ditangani</div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-semibold">{{ $agent['response'] }} hari</div>
                                        <div class="text-muted small">Rata-rata Respon</div>
                                    </div>
                                    <div class="text-end ms-4">
                                        <div class="fw-semibold">{{ $agent['rating'] }}/5.0</div>
                                        <div class="text-muted small">Rating</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @include('partials.dashboard.charts._tren-sla')
                </div>
            </div>

        </div>
    </div>

</x-default-layout>