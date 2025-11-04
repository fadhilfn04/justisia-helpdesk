
<div class="card shadow-sm rounded-3 p-4 bg-light">
    <h4 class="fw-bold mb-1">Kinerja Bulanan</h4>
    <p class="text-muted mb-4">Tiket masuk vs selesai per bulan</p>

    <div id="kinerjaChart"></div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kinerjaData = @json($kinerjaBulanan);

        var categories = kinerjaData.map(d => d.bulan);
        var dataMasuk  = kinerjaData.map(d => d.masuk);
        var dataSelesai = kinerjaData.map(d => d.selesai);

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
                    data: dataMasuk,
                    color: '#3B82F6'
                },
                {
                    name: 'Tiket Selesai',
                    data: dataSelesai,
                    color: '#10B981'
                }
            ],
            xaxis: {
                categories: categories,
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                min: 0,
                tickAmount: 6,
                labels: { formatter: val => val }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 4,
            },
            tooltip: {
                y: {
                    formatter: val => val + " tiket"
                }
            },
            legend: { show: false },
        };

        var chart = new ApexCharts(document.querySelector("#kinerjaChart"), options);
        chart.render();
    });
</script>
@endpush

