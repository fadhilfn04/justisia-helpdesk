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
</x-default-layout>