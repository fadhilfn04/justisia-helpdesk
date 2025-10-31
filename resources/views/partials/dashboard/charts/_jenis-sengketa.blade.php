<div class="card shadow-sm border-0 h-100">
    <div class="card-header">
        <div class="card-title">
            <h2>Jenis Sengketa</h2>
        </div>
    </div>
    <div class="card-body">
        <div id="chartJenisSengketa"></div>
    </div>
</div>

@push('scripts')
<script>
    const optionsJenis = {
        chart: {
            type: 'donut',
            height: 300
        },
        labels: [
            'Sengketa Batas',
            'Konflik Kepemilikan',
            'Cacat Administrasi',
            'Putusan Pengadilan'
        ],
        series: [35, 28, 22, 15],
        colors: ['#4e73df', '#f6c23e', '#36b9cc', '#e74a3b'],
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
                            formatter: () => '100%'
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