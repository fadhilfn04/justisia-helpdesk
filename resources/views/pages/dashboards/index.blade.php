<x-default-layout>
    @section('title', 'Dashboard Utama')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    {{-- <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body pt-0"> --}}
            <ul class="nav nav-tabs nav-line-tabs mt-3 mb-6 fs-6">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_overview">Overview</a>
                </li>
                @if (auth()->user()->role->id != '3')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_realtime">Real-Time</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_notifikasi">Notifikasi</a>
                </li>
            </ul>
            <div class="tab-content" id="dashboardTabs">

                {{-- === TAB OVERVIEW === --}}
                <div class="tab-pane fade show active" id="tab_overview" role="tabpanel">
                    <div class="row g-5 mb-5">
                        <div class="col-md-3 col-sm-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Total Tiket Aktif</h6>
                                    <h3 class="fw-bold text-success mb-1">{{ $totalTickets }}</h3>
                                    <small class="text-muted">+12% dari bulan lalu</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Pembatalan Sertifikat</h6>
                                    <h3 class="fw-bold text-danger mb-1">89</h3>
                                    <small class="text-muted">+5% dari bulan lalu</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Kasus Sengketa</h6>
                                    <h3 class="fw-bold text-warning mb-1">456</h3>
                                    <small class="text-muted">+8% dari bulan lalu</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Tingkat Penyelesaian</h6>
                                    <h3 class="fw-bold text-primary mb-1">{{ $resolutionRate }} %</h3>
                                    <small class="text-muted">+2.1% dari bulan lalu</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->role->id != '3')
                        <div class="row g-5 mb-5">
                            <div class="col-xl-8">
                                @include('partials.dashboard.charts._tren-tiket-bulanan')
                            </div>
                            <div class="col-xl-4">
                                @include('partials.dashboard.charts._jenis-sengketa')
                            </div>
                        </div>

                        <div class="row g-5 mb-5">
                            <div class="col-xl-8">
                                @include('partials.dashboard.tables._tiket-terbaru')
                            </div>
                            {{-- <div class="col-xl-4">
                                @include('partials.dashboard.cards._distribusi-regional')
                            </div> --}}
                        </div>
                    @endif

                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body py-4">
                            <h5 class="fw-bold">Aksi Cepat</h5>
                            <p class="text-muted mb-4">Akses fitur utama dengan cepat</p>

                            <div class="row g-3">
                                <div class="col-md col-sm-6">
                                    <a href="{{ route('tiket.index') }}" class="text-decoration-none">
                                        <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                                            <div class="fs-1 mb-2 text-primary">
                                                <i class="bi bi-ticket-perforated"></i>
                                            </div>
                                            <div class="fw-semibold text-dark">Buat Tiket Baru</div>
                                        </div>
                                    </a>
                                </div>

                                @if (auth()->user()->role->id != '3')
                                    <div class="col-md col-sm-6">
                                        <a href="{{ route('user-management.users.index') }}" class="text-decoration-none">
                                            <div class="quick-action-card text-center p-4 rounded-3 border bg-white h-100">
                                                <div class="fs-1 mb-2 text-success">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                                <div class="fw-semibold text-dark">Manajemen User</div>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                {{-- === TAB REAL-TIME === --}}
                <div class="tab-pane fade" id="tab_realtime" role="tabpanel">

                    {{-- Status Bar --}}
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-5">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2"></span>
                                    <span class="fw-semibold">Status: Online</span>
                                    <span class="text-muted ms-2" id="last-update-text">Terakhir update: --:--:--</span>
                                </div>
                                <button id="refresh-realtime-btn" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-repeat me-2"></i>Refresh Data
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="row g-5 mb-5">
                        @include('partials.dashboard.cards._status-tiket')
                    </div>

                    {{-- Real-Time Activity + Chart --}}
                    <div class="row g-5 mb-5">
                        <div class="col-xl-6" id="realtime-activity-container">
                            @include('partials.dashboard.tables._aktivitas-real-time')
                        </div>

                        <div class="col-xl-6">
                            @include('partials.dashboard.charts._tiket-harian')
                        </div>
                    </div>

                    {{-- Monitoring SLA --}}
                    @include('partials.dashboard.tables._monitoring-sla')
                </div>

                {{-- === TAB NOTIFIKASI === --}}
                <div class="tab-pane fade" id="tab_notifikasi" role="tabpanel">
                    @include('partials.dashboard.cards._notifikasi')
                </div>

            </div>
        {{-- </div>
    </div> --}}

@push('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const realtimeUrl = "{{ route('dashboard.realtime') }}";
        const refreshBtn = document.getElementById("refresh-realtime-btn");
        const lastUpdateText = document.getElementById("last-update-text");

        let chart;

        const options = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            stroke: { width: 2, curve: 'smooth' },
            markers: { size: 4, hover: { sizeOffset: 4 } },
            series: [
                { name: 'Tiket Masuk', data: [] },
                { name: 'Tiket Selesai', data: [] }
            ],
            xaxis: {
                categories: [],
                labels: { rotate: -45 }
            },
            yaxis: {
                min: 0,
                tickAmount: 5,
                labels: { formatter: val => parseInt(val) }
            },
            colors: ['#3b82f6', '#10b981'],
            legend: { position: 'top', horizontalAlign: 'left' },
            grid: { borderColor: '#e5e7eb', strokeDashArray: 4 }
        };

        chart = new ApexCharts(document.querySelector("#trenTiketHarian"), options);
        chart.render();

        function updateRealtimeData() {
            fetch(realtimeUrl)
                .then(res => res.json())
                .then(data => {
                    const s = data.ticket_status ?? {};

                    document.getElementById('total-tiket').textContent = s.total_tiket ?? '-';
                    document.getElementById('waktu-respon').textContent = s.rata_rata_waktu_respon ?? '-';
                    document.getElementById('sla-compliance').textContent = s.sla_compliance ?? '-';

                    if (data.ticket_daily_trends) {
                        chart.updateOptions({
                            xaxis: { categories: data.ticket_daily_trends.categories },
                            series: [
                                { name: 'Tiket Masuk', data: data.ticket_daily_trends.masuk },
                                { name: 'Tiket Selesai', data: data.ticket_daily_trends.selesai }
                            ]
                        });
                    }

                    const now = new Date();
                    lastUpdateText.textContent = `Terakhir update: ${now.toLocaleTimeString('id-ID', { hour12: false })}`;
                })
                .catch(err => console.error('[Realtime Error]', err));
        }

        function updateOnlineAgent() {
            fetch(realtimeUrl)
                .then(res => res.json())
                .then(data => {
                    const onlineAgent = data.online_agents ?? {};

                    document.getElementById('agen-online').textContent = onlineAgent.agen_online;
                    document.getElementById('total-agen').textContent = `dari ${onlineAgent.total_agen} total agen`;
                })
                .catch(err => console.error('[AgenOnline Error]', err));
        }
        
        function recentActivities() {
            fetch(realtimeUrl)
                .then(res => res.json())
                .then(data => {
                    const recentActivities = data.recent_activities ?? {};

                    document.getElementById('realtime-activity-container').innerHTML = data.html;
                })
                .catch(err => console.error('[recentActivities Error]', err));
        }

        updateRealtimeData();
        updateOnlineAgent();
        recentActivities();

        const POLL_INTERVAL = 60000;
        setInterval(() => {
            if (document.querySelector('#tab_realtime').classList.contains('active')) {
                updateRealtimeData();
                updateOnlineAgent();
                recentActivities();
            }
        }, POLL_INTERVAL);

        refreshBtn.addEventListener('click', updateRealtimeData);
    });
    </script>
@endpush

</x-default-layout>
