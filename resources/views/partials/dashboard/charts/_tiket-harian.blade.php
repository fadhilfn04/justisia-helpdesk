<div class="card h-100">
    <div class="card-body">
        <h3 class="card-title mb-2">Tren Tiket Harian</h3>
        <span class="text-muted">Tiket masuk vs diselesaikan per jam</span>

        <div id="trenTiketHarian" style="height: 350px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                markers: {
                    size: 4,
                    hover: { sizeOffset: 4 }
                },
                series: [
                    {
                        name: 'Tiket Masuk',
                        data: [15, 7, 18, 6, 24, 12, 13, 14, 12, 12, 10, 14, 13, 11, 13, 15, 19, 18, 17, 14, 13, 20, 22, 23]
                    },
                    {
                        name: 'Tiket Selesai',
                        data: [6, 5, 12, 9, 10, 15, 10, 12, 11, 9, 7, 5, 6, 8, 7, 16, 14, 10, 12, 11, 8, 9, 11, 6]
                    }
                ],
                xaxis: {
                    categories: [
                        '00:00', '01:00', '02:00', '03:00', '04:00', '05:00',
                        '06:00', '07:00', '08:00', '09:00', '10:00', '11:00',
                        '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
                        '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
                    ],
                    labels: {
                        rotate: -45
                    }
                },
                yaxis: {
                    min: 0,
                    max: 25,
                    tickAmount: 5,
                    labels: {
                        formatter: function (val) {
                            return parseInt(val);
                        }
                    }
                },
                colors: ['#3b82f6', '#10b981'], // biru & hijau (Metronic friendly)
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4
                }
            };

            const chart = new ApexCharts(document.querySelector("#trenTiketHarian"), options);
            chart.render();
        });
    </script>
@endpush