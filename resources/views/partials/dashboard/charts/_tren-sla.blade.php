<div class="card shadow-sm rounded-3 p-4 bg-light">
    <h4 class="fw-bold mb-1">Tren SLA & Penyelesaian</h4>
    <p class="text-muted mb-4">Tren per minggu berdasarkan status tiket</p>
    <div id="slaChart"></div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slaData = @json($trenSLA);

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

        new ApexCharts(document.querySelector("#slaChart"), options).render();
    });
</script>
@endpush