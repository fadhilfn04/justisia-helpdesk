<div class="card shadow-sm border-0 h-100 bg-light">
    <div class="card-header">
        <div class="card-title">
            Distribusi Kategori
        </div>
    </div>
    <div class="card-body">
        <div id="chartJenisSengketa"></div>
    </div>
</div>

@push('scripts')
<script>
    const kategoriData = @json($distribusiKategori);
    const labels = kategoriData.map(item => item.kategori);
    const series = kategoriData.map(item => item.jumlah);

    const optionsJenis = {
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

    const chartJenis = new ApexCharts(document.querySelector("#chartJenisSengketa"), optionsJenis);
    chartJenis.render();
</script>
@endpush