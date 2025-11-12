<x-default-layout>

    @section('title')
        Laporan & Analitik
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('laporan.index') }}
    @endsection

    <div class="card shadow-sm border-0 rounded-3 mb-7">
        <div class="card-body py-5 px-6">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                    <select id="filterPeriode" class="form-select form-select-sm w-auto">
                        <option value="">Semua Periode</option>
                        <option value="daily">Harian</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                    
                    <select id="filterWilayah" class="form-select form-select-sm w-auto">
                        <option value="">Semua Wilayah</option>
                        @foreach ($daftarWilayah as $wilayah)
                            <option value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                        @endforeach
                    </select>

                    <select id="filterKategori" class="form-select form-select-sm w-auto">
                        <option value="">Semua Kategori</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-3">
                    <button class="btn btn-light-primary d-flex align-items-center gap-2">
                        <i class="ki-outline ki-exit-up fs-3"></i> Export Excel
                    </button>
                    <button class="btn btn-light-danger d-flex align-items-center gap-2">
                        <i class="ki-outline ki-file fs-3"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-7">
        <div class="card-header border-0 pb-0 bg-transparent">
            <ul class="nav nav-tabs nav-line-tabs fs-6" role="tablist" style="--bs-nav-link-color:#7a7a7a; --bs-nav-link-hover-color:#0d6efd;">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab_overview">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab_kinerja">Kinerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab_regional">Regional</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab_tren">Tren</a>
                </li>
            </ul>
        </div>

        <div class="card-body tab-content mt-4" id="reportTabs">
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

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterPeriode = document.getElementById('filterPeriode');
        const filterWilayah = document.getElementById('filterWilayah');
        const filterKategori = document.getElementById('filterKategori');

        let kinerjaBulananChart = null;
        let distribusiKategoriChart = null;
        let trenSlaChart = null;
        let kinerjaRegionalChart = null;

        [filterPeriode, filterWilayah, filterKategori].forEach(select => {
            select.addEventListener('change', () => {
                fetchStatistik();
                fetchKinerjaBulanan();
                fetchDistribusiKategori();
                fetchKinerjaAgenList();
                fetchTrenSla();
                fetchKinerjaRegional();
            });
        });

        function fetchStatistik() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/statistik-kinerja?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateStatistik(data))
                .catch(error => console.error('Error Statistik:', error));
        }

        function updateStatistik(data) {
            const fields = {
                total_tiket: data.total_tiket,
                tingkat_penyelesaian: data.tingkat_penyelesaian + ' %',
                rata_rata_waktu_respon: data.rata_rata_waktu_respon + ' hari',
                sla_compliance: data.sla_compliance + ' %'
            };

            Object.entries(fields).forEach(([key, value]) => {
                const el = document.querySelector(`[data-field="${key}"]`);
                if (el) animateValue(el, value);
            });
        }

        function animateValue(element, newValue) {
            const oldValue = parseFloat(element.textContent) || 0;
            const numericNewValue = parseFloat(newValue);
            const isPercentage = newValue.toString().includes('%');
            const isHari = newValue.toString().includes('hari');

            let start = oldValue;
            const end = numericNewValue;
            const duration = 500;
            const startTime = performance.now();

            function update(currentTime) {
                const progress = Math.min((currentTime - startTime) / duration, 1);
                const current = Math.floor(start + (end - start) * progress);
                element.textContent = current + (isPercentage ? ' %' : isHari ? ' hari' : '');
                if (progress < 1) requestAnimationFrame(update);
            }

            requestAnimationFrame(update);
        }

        function fetchKinerjaBulanan() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/kinerja-bulanan?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateKinerjaBulananChart(data))
                .catch(error => console.error('Error Chart:', error));
        }

        function updateKinerjaBulananChart(data) {
            const categories = data.map(d => d.bulan);
            const dataMasuk  = data.map(d => d.masuk);
            const dataSelesai = data.map(d => d.selesai);

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '40%',
                        borderRadius: 4,
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                series: [
                    { name: 'Tiket Masuk', data: dataMasuk, color: '#3B82F6' },
                    { name: 'Tiket Selesai', data: dataSelesai, color: '#10B981' }
                ],
                xaxis: {
                    categories: categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: { min: 0, tickAmount: 6, labels: { formatter: val => val } },
                grid: { borderColor: '#e5e7eb', strokeDashArray: 4 },
                tooltip: { y: { formatter: val => val + " tiket" } },
                legend: { show: false },
            };

            if (kinerjaBulananChart) {
                kinerjaBulananChart.updateOptions(options);
            } else {
                kinerjaBulananChart = new ApexCharts(document.querySelector("#kinerjaBulananChart"), options);
                kinerjaBulananChart.render();
            }
        }

        function fetchDistribusiKategori() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/distribusi-kategori?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateDistribusiKategoriChart(data))
                .catch(error => console.error('Error Chart:', error));
        }

        function updateDistribusiKategoriChart(data) {
            const labels  = data.map(d => d.kategori);
            const series = data.map(d => d.jumlah);

            const options = {
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: labels,
                series: series,
                colors: ['#4e73df', '#f6c23e', '#36b9cc', '#e74a3b', '#858796', '#1cc88a', '#e83e8c'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => val.toFixed(1) + '%'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: (w) => {
                                        const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return total;
                                    }
                                }
                            }
                        }
                    }
                }
            };

            if (distribusiKategoriChart) {
                distribusiKategoriChart.updateOptions(options);
            } else {
                distribusiKategoriChart = new ApexCharts(document.querySelector("#distribusiKategoriChart"), options);
                distribusiKategoriChart.render();
            }
        }

        function fetchKinerjaAgenList() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/kinerja-agen?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateKinerjaAgenList(data))
                .catch(error => console.error('Error Kinerja Agen:', error));
        }

        function updateKinerjaAgenList(data) {
            const container = document.getElementById('kinerjaAgenList');
            container.innerHTML = '';

            if (!data || data.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="fa-regular fa-face-smile-beam fs-3 mb-2"></i><br>
                        Belum ada data kinerja agen.
                    </div>`;
                return;
            }

            data.forEach(agent => {
                const initials = agent.nama.split(' ')
                    .map(n => n.charAt(0).toUpperCase())
                    .join('');

                const ratingColor =
                    agent.rating >= 4.5 ? 'text-success' :
                    agent.rating >= 3.5 ? 'text-warning' : 'text-danger';

                const item = `
                    <div class="list-group-item d-flex align-items-center justify-content-between border-0 px-0 py-3 rounded-3 mb-2 bg-light-hover transition">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 42px; height: 42px;">
                                ${initials}
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">${agent.nama}</div>
                                <div class="text-muted small">
                                    <i class="fa-solid fa-briefcase me-1"></i> ${agent.tiket_selesai} tiket ditangani
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-4">
                            <div class="text-end">
                                <div class="fw-semibold text-dark">
                                    <i class="fa-regular fa-clock me-1 text-secondary"></i>${agent.sla_rata} hari
                                </div>
                                <div class="text-muted small">Rata-rata SLA</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold ${ratingColor}">
                                    <i class="fa-solid fa-star me-1 text-warning"></i>${Number(agent.rating).toFixed(1)}/5.0
                                </div>
                                <div class="text-muted small">Rating</div>
                            </div>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', item);
            });
        }

        function fetchTrenSla() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/tren-sla?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateTrenSlaChart(data))
                .catch(error => console.error('Error Chart:', error));
        }

        function updateTrenSlaChart(data) {
            const slaData  = data;

            const options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                },
                series: [
                    {
                        name: 'Tingkat Penyelesaian (%)',
                        data: slaData.map(d => d.tingkat_penyelesaian),
                        color: '#3B82F6'
                    },
                    {
                        name: 'Rata-rata SLA (hari)',
                        data: slaData.map(d => d.rata_sla),
                        color: '#10B981'
                    }
                ],
                stroke: {
                    curve: 'smooth',
                    width: 3,
                },
                markers: {
                    size: 4,
                    strokeWidth: 2,
                    hover: { size: 6 }
                },
                grid: {
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } }
                },
                xaxis: {
                    categories: slaData.map(d => d.minggu),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: [
                    {
                        title: { text: "Persentase (%)" },
                        min: 0, max: 100
                    },
                    {
                        opposite: true,
                        title: { text: "Hari" },
                    }
                ],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: (val, opts) => opts.seriesIndex === 0 ? val.toFixed(1) + "%" : val.toFixed(2) + " hari"
                    }
                },
                legend: {
                    position: 'bottom'
                }
            };

            if (trenSlaChart) {
                trenSlaChart.updateOptions(options);
            } else {
                trenSlaChart = new ApexCharts(document.querySelector("#trenSlaChart"), options);
                trenSlaChart.render();
            }
        }

        function fetchKinerjaRegional() {
            const periode = filterPeriode.value;
            const wilayah = filterWilayah.value;
            const kategori = filterKategori.value;

            fetch(`/laporan/kinerja-regional?periode=${periode}&wilayah=${wilayah}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => updateTrenSlaChart(data))
                .catch(error => console.error('Error Chart:', error));
        }

        function updateKinerjaRegionalChart(data) {
            const slaData  = data;

            const options = {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: 'Rata-rata SLA (hari)',
                    data: slaData,
                    color: '#3B82F6'
                }],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '45%',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => `${val.toFixed(1)}h`,
                    offsetY: -15,
                    style: {
                        fontSize: '12px',
                        colors: ['#6B7280']
                    }
                },
                xaxis: {
                    categories: regions,
                    labels: { style: { fontSize: '13px' } },
                    axisTicks: { show: false },
                    axisBorder: { show: false }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: { radius: 6 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: val => `${val.toFixed(2)} jam` }
                }
            };

            if (kinerjaRegionalChart) {
                kinerjaRegionalChart.updateOptions(options);
            } else {
                kinerjaRegionalChart = new ApexCharts(document.querySelector("#kinerjaRegionalChart"), options);
                kinerjaRegionalChart.render();
            }
        }

        fetchStatistik();
        fetchKinerjaBulanan();
        fetchDistribusiKategori();
        fetchKinerjaAgenList();
        fetchTrenSla();
        fetchKinerjaRegional();
    });
    </script>
@endpush

</x-default-layout>