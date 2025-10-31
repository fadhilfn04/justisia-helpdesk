<div class="card shadow-sm rounded-3 p-4 bg-light">
    <h4 class="fw-bold mb-1">Tren SLA Compliance</h4>
    <p class="text-muted mb-4">Persentase kepatuhan SLA per bulan</p>
    <div id="slaChart"></div>
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
                    name: 'SLA Compliance',
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
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                tooltip: {
                    y: { formatter: val => val + "%" }
                }
            };

            const chart = new ApexCharts(document.querySelector("#slaChart"), options);
            chart.render();
        });
    </script>
@endpush
