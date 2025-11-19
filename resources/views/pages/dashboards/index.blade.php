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

                <div class="tab-pane fade show active" id="tab_overview" role="tabpanel">
                    <div class="row g-4 mb-5">
                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <div class="card-body d-flex align-items-center p-4">
                                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 me-3 p-3">
                                        <i class="bi bi-ticket-perforated fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-semibold text-uppercase">Total Tiket Aktif</div>
                                        <h3 class="fw-bold text-dark mb-1">{{ $ticketStatus['tiket_aktif'] }}</h3>
                                        <small class="text-success fw-semibold d-flex align-items-center gap-1">
                                            <i class="bi bi-arrow-up-short"></i>
                                            +{{ $ticketStatus['kenaikan_tiket_bulan_ini'] }}% dari bulan lalu
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <div class="card-body d-flex align-items-center p-4">
                                    <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-3 me-3 p-3">
                                        <i class="bi bi-x-circle fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-semibold text-uppercase">Pembatalan Sertifikat</div>
                                        <h3 class="fw-bold text-dark mb-1">-</h3>
                                        <small class="text-muted">-% dari bulan lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <div class="card-body d-flex align-items-center p-4">
                                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 me-3 p-3">
                                        <i class="bi bi-exclamation-triangle fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-semibold text-uppercase">Kasus Sengketa</div>
                                        <h3 class="fw-bold text-dark mb-1">-</h3>
                                        <small class="text-muted">-% dari bulan lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                <div class="card-body d-flex align-items-center p-4">
                                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-3 me-3 p-3">
                                        <i class="bi bi-graph-up-arrow fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-semibold text-uppercase">Tingkat Penyelesaian</div>
                                        <h3 class="fw-bold text-dark mb-1">{{ $resolutionRate }}%</h3>
                                        <small class="text-muted">-% dari bulan lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->role->id != '3')
                        <div class="row g-5 mb-5">
                            <div class="col">
                                @include('partials.dashboard.charts._tren-tiket-bulanan')
                            </div>
                            {{-- <div class="col-xl-4">
                                @include('partials.dashboard.charts._jenis-sengketa')
                            </div> --}}
                        </div>

                        <div class="row g-5 mb-5">
                            <div class="col">
                                @include('partials.dashboard.tables._tiket-terbaru')
                            </div>
                            {{-- <div class="col-xl-4">
                                @include('partials.dashboard.cards._distribusi-regional')
                            </div> --}}
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="tab_realtime" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 mb-5">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                {{-- Kiri: Status & Waktu Update --}}
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-circle-fill me-2 small text-success"></i>
                                        <span class="fw-semibold">Status: Online</span>
                                    </div>
                                    <span class="text-muted small ms-2" id="last-update-text">
                                        <i class="bi bi-clock-history me-1"></i>Terakhir update: --:--:--
                                    </span>
                                </div>

                                {{-- Kanan: Tombol Refresh --}}
                                <button id="refresh-realtime-btn" class="btn btn-light-primary btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Refresh Data</span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="row g-5 mb-5">
                        @include('partials.dashboard.cards._status-tiket')
                    </div>

                    <div class="row g-5 mb-5">
                        <div class="col-xl-6" id="realtime-activity-container">
                            @include('partials.dashboard.tables._aktivitas-real-time')
                        </div>

                        <div class="col-xl-6">
                            @include('partials.dashboard.charts._tiket-harian')
                        </div>
                    </div>

                    <div id="sla-monitoring-container">
                        @include('partials.dashboard.tables._monitoring-sla')
                    </div>
                </div>

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
            chart: { type: 'line', height: 350, toolbar: { show: false }, zoom: { enabled: false } },
            stroke: { width: 2, curve: 'smooth' },
            markers: { size: 4, hover: { sizeOffset: 4 } },
            series: [
                { name: 'Tiket Masuk', data: [] },
                { name: 'Tiket Selesai', data: [] }
            ],
            xaxis: { categories: [], labels: { rotate: -45 } },
            yaxis: { min: 0, tickAmount: 5, labels: { formatter: val => parseInt(val) } },
            colors: ['#3b82f6', '#10b981'],
            legend: { position: 'top', horizontalAlign: 'left' },
            grid: { borderColor: '#e5e7eb', strokeDashArray: 4 }
        };

        chart = new ApexCharts(document.querySelector("#trenTiketHarian"), options);
        chart.render();

        async function fetchRealtimeData() {
            try {
                const res = await fetch(realtimeUrl);
                const data = await res.json();

                updateRealtimeData(data);
                updateOnlineAgent(data);
                updateRecentActivities(data);
                updateMonitoringSLA(data);

                const now = new Date();
                lastUpdateText.textContent = `Terakhir update: ${now.toLocaleTimeString('id-ID', { hour12: false })}`;
            } catch (err) {
                console.error('[Realtime Error]', err);
            }
        }

        function updateRealtimeData(data) {
            const s = data.ticket_status ?? {};

            document.getElementById('total-tiket').textContent = s.tiket_aktif ?? '-';
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
        }

        function updateOnlineAgent(data) {
            const onlineAgent = data.online_agents ?? {};
            document.getElementById('agen-online').textContent = onlineAgent.agen_online;
            document.getElementById('total-agen').textContent = `dari ${onlineAgent.total_agen} total agen`;
        }

        function updateRecentActivities(data) {
            document.getElementById('realtime-activity-container').innerHTML = data.htmlActivities ?? '<div class="text-center text-muted py-5">Belum ada aktivitas.</div>';
        }

        function updateMonitoringSLA(data) {
            document.getElementById('sla-monitoring-container').innerHTML = data.htmlSLA ?? '<div class="text-center text-muted py-5">Belum ada data SLA.</div>';
        }

        fetchRealtimeData();

        const POLL_INTERVAL = 60000;
        setInterval(() => {
            if (document.querySelector('#tab_realtime').classList.contains('active')) {
                fetchRealtimeData();
            }
        }, POLL_INTERVAL);

        refreshBtn.addEventListener('click', async () => {
            refreshBtn.disabled = true;
            const originalText = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Memuat...';

            await fetchRealtimeData();

            refreshBtn.innerHTML = originalText;
            refreshBtn.disabled = false;
        });
    });
    </script>
@endpush
</x-default-layout>
