<div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="fw-bold mb-1">Kinerja Wilayah Kantor</h4>
            <p class="text-muted mb-0">Perbandingan rata-rata waktu penyelesaian antar wilayah kantor</p>
        </div>
        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2">
            Data {{ now()->translatedFormat('F Y') }}
        </span>
    </div>

    <div id="kinerjaRegionalChart" class="mt-4"></div>
</div>

<div class="card shadow-sm rounded-3 p-4 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="fw-bold mb-1">Tingkat Penyelesaian Wilayah Kantor</h4>
            <p class="text-muted mb-0">Ringkasan jumlah tiket dan rata-rata waktu respon tiap wilayah kantor</p>
        </div>
        <i class="ki-outline ki-map fs-2 text-gray-500"></i>
    </div>

    <div class="mt-4">
        @foreach ($kinerjaRegional as $region)
            @php
                $initials = collect(explode(' ', $region['wilayah']))->map(fn($n) => strtoupper($n[0]))->join('');
            @endphp

            <div class="d-flex align-items-center justify-content-between border rounded-3 p-3 mb-2 bg-white hover-shadow-sm transition">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 42px; height: 42px;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $region['wilayah'] }}</div>
                        <div class="text-muted small">{{ $region['tiket_selesai'] }} tiket selesai</div>
                    </div>
                </div>

                <div class="text-end">
                    <div class="fw-semibold text-gray-800">{{ $region['rata_respon'] }} hari</div>
                    <div class="text-muted small">Rata-rata Respon</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const kinerjaRegional = @json($kinerjaRegional);

        const regions = kinerjaRegional.map(r => r.wilayah);
        const slaData = kinerjaRegional.map(r => r.rata_respon);

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

        new ApexCharts(document.querySelector("#kinerjaRegionalChart"), options).render();
    });
</script>
@endpush