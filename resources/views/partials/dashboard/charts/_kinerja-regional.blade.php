<div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
    <h4 class="fw-bold mb-1">Kinerja Regional</h4>
    <p class="text-muted mb-4">Perbandingan kinerja antar wilayah</p>
    <div id="kinerjaRegionalChart"></div>
</div>

<div class="card shadow-sm rounded-3 p-4 bg-light">
    <h4 class="fw-bold mb-1">Tingkat Penyelesaian Regional</h4>
    <p class="text-muted mb-4">Persentase penyelesaian tiket per wilayah</p>

    @php
        $agents = [
            ['name' => 'DKI Jakarta', 'tickets' => 45, 'response' => 2.5, 'rating' => 4.8],
            ['name' => 'Jawa Barat', 'tickets' => 38, 'response' => 3.2, 'rating' => 4.6],
            ['name' => 'Banten', 'tickets' => 42, 'response' => 2.8, 'rating' => 4.7],
            ['name' => 'Jawa Tengah', 'tickets' => 35, 'response' => 3.5, 'rating' => 4.4],
            ['name' => 'Jawa Timur', 'tickets' => 28, 'response' => 4.1, 'rating' => 4.2],
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                },
                series: [{
                    name: 'Kinerja Regional',
                    data: [87, 89, 85, 90, 86, 91],
                    color: '#3B82F6'
                }],
                stroke: {
                    curve: 'smooth',
                    width: 3,
                },
                markers: {
                    size: 4,
                    colors: ['#3B82F6'],
                    strokeWidth: 2,
                    hover: { size: 6 }
                },
                grid: {
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } }
                },
                yaxis: {
                    min: 80,
                    max: 95,
                    tickAmount: 5,
                },
                xaxis: {
                    categories: ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Jawa Timur', 'Sumatera Utara'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                tooltip: {
                    y: { formatter: val => val + "%" }
                }
            };

            const chart = new ApexCharts(document.querySelector("#kinerjaRegionalChart"), options);
            chart.render();
        });
    </script>
@endpush
