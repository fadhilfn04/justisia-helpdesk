<x-default-layout>
    @section('title', 'Dashboard Utama')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!-- ============================= -->
    <!-- TOP SUMMARY CARDS -->
    <!-- ============================= -->
    <div class="row g-5 mb-5">
        <div class="col-md-3 col-sm-6">
            @include('partials.dashboard.cards._total-tiket')
        </div>
        <div class="col-md-3 col-sm-6">
            @include('partials.dashboard.cards._pembatalan-sertifikat')
        </div>
        <div class="col-md-3 col-sm-6">
            @include('partials.dashboard.cards._kasus-sengketa')
        </div>
        <div class="col-md-3 col-sm-6">
            @include('partials.dashboard.cards._tingkat-penyelesaian')
        </div>
    </div>

    <!-- ============================= -->
    <!-- CHARTS ROW -->
    <!-- ============================= -->
    <div class="row g-5 mb-5">
        <div class="col-xl-8">
            @include('partials.dashboard.charts._tren-tiket-bulanan')
        </div>
        <div class="col-xl-4">
            @include('partials.dashboard.charts._jenis-sengketa')
        </div>
    </div>

    <!-- ============================= -->
    <!-- TABLE + REGIONAL DISTRIBUTION -->
    <!-- ============================= -->
    <div class="row g-5 mb-5">
        <div class="col-xl-8">
            @include('partials.dashboard.tables._tiket-terbaru')
        </div>
        <div class="col-xl-4">
            @include('partials.dashboard.cards._distribusi-regional')
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body py-4">
            <h5 class="fw-bold">Aksi Cepat</h5>
            <p class="text-muted mb-4">Akses fitur utama dengan cepat</p>

            <div class="row g-3">
                <!-- Buat Tiket Baru -->
                <div class="col-md-3 col-sm-6">
                    <a href="#" class="text-decoration-none">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                            <div class="fs-1 mb-2 text-primary">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <div class="fw-semibold text-dark">Buat Tiket Baru</div>
                        </div>
                    </a>
                </div>

                <!-- Pembatalan Sertifikat -->
                <div class="col-md-3 col-sm-6">
                    <a href="#" class="text-decoration-none">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                            <div class="fs-1 mb-2 text-danger">
                                <i class="bi bi-file-earmark-x"></i>
                            </div>
                            <div class="fw-semibold text-dark">Pembatalan Sertifikat</div>
                        </div>
                    </a>
                </div>

                <!-- Daftar Sengketa -->
                <div class="col-md-3 col-sm-6">
                    <a href="#" class="text-decoration-none">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                            <div class="fs-1 mb-2 text-warning">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="fw-semibold text-dark">Daftar Sengketa</div>
                        </div>
                    </a>
                </div>

                <!-- Manajemen User -->
                <div class="col-md-3 col-sm-6">
                    <a href="#" class="text-decoration-none">
                        <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                            <div class="fs-1 mb-2 text-success">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="fw-semibold text-dark">Manajemen User</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>