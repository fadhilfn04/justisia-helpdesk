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
    const monthlyTrends = @json($monthlyTrends);

    const optionsTren = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: { show: false }
        },
        series: [
            {
                name: 'Tiket Masuk',
                data: monthlyTrends.masuk
            },
            {
                name: 'Tiket Selesai',
                data: monthlyTrends.selesai
            }
        ],
        xaxis: {
            categories: monthlyTrends.categories
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