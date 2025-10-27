
<div class="card shadow-sm rounded-3 p-4 bg-light">
    <h4 class="fw-bold mb-1">Kinerja Bulanan</h4>
    <p class="text-muted mb-4">Tiket masuk vs selesai per bulan</p>

    <div id="kinerjaChart"></div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
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
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [
                    {
                        name: 'Tiket Masuk',
                        data: [125, 135, 150, 165, 155, 175],
                        color: '#3B82F6' // biru
                    },
                    {
                        name: 'Tiket Selesai',
                        data: [95, 110, 130, 140, 138, 155],
                        color: '#10B981' // hijau
                    }
                ],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    min: 0,
                    max: 180,
                    tickAmount: 6,
                    labels: {
                        formatter: function (val) {
                            return val;
                        }
                    }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " tiket";
                        }
                    }
                },
                legend: { show: false },
            };

            var chart = new ApexCharts(document.querySelector("#kinerjaChart"), options);
            chart.render();
        });
    </script>
@endpush

