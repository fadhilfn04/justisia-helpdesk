<div class="card shadow-sm border-0">
    <div class="card-header">
        <div class="card-title">
            <h2>Tren Tiket Bulanan</h2>
        </div>
    </div>
    <div class="card-body">
        <div id="chartTrenTiket"></div>
    </div>
</div>

@push('scripts')
<script>
    const optionsTren = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: { show: false }
        },
        series: [
            {
                name: 'Tiket Masuk',
                data: [120, 140, 150, 160, 170, 180]
            },
            {
                name: 'Tiket Selesai',
                data: [100, 120, 130, 150, 160, 175]
            }
        ],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#008FFB', '#00E396'],
        dataLabels: { enabled: false },
        legend: { position: 'top' },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { theme: 'light' }
    };

    const chartTren = new ApexCharts(document.querySelector("#chartTrenTiket"), optionsTren);
    chartTren.render();
</script>
@endpush