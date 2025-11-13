<div class="card shadow-sm rounded-4 p-4 mb-6 bg-white border-0">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">📈 Tren Tiket Harian</h4>
            <p class="text-muted mb-0">Perkembangan tiket dan penyelesaian per hari</p>
        </div>
    </div>
    <hr class="my-4 text-muted opacity-25">
    <div id="chartTrenTiketHarian"></div>
</div>

<!-- Statistik Kinerja -->
<div class="card shadow-sm rounded-4 p-4 mb-6 bg-white border-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">📊 Prediksi Beban Kerja</h4>
            <p class="text-muted mb-0">Estimasi berdasarkan tren historis 3 bulan terakhir</p>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-graph fs-2x text-primary mb-3"></i>
                <div class="fs-1 fw-bold text-dark">{{ $statistikKinerja['prediksi_tiket_masuk'] }}</div>
                <div class="fs-7 text-muted mb-1">Prediksi Tiket Masuk</div>
                <span class="badge {{ $statistikKinerja['growth'] >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $statistikKinerja['growth'] >= 0 ? 'success' : 'danger' }} fs-8">
                    {{ $statistikKinerja['growth'] >= 0 ? '+' : '' }}{{ $statistikKinerja['growth'] }}% dari bulan ini
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-chart-line-up fs-2x text-success mb-3"></i>
                <div class="fs-1 fw-bold text-dark">{{ $statistikKinerja['prediksi_selesai'] }}</div>
                <div class="fs-7 text-muted mb-1">Estimasi Tiket Selesai</div>
                <span class="badge bg-success bg-opacity-10 text-success fs-8">
                    {{ $statistikKinerja['completion_rate'] }}% completion rate
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-calendar fs-2x text-danger mb-3"></i>
                <div class="fs-1 fw-bold text-dark">{{ $statistikKinerja['backlog'] }}</div>
                <div class="fs-7 text-muted mb-1">Kemungkinan Backlog</div>
                <span class="badge bg-danger bg-opacity-10 text-danger fs-8">
                    {{ $statistikKinerja['backlog'] > 0 ? 'Perlu perhatian' : 'Stabil' }}
                </span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const trenData = @json($trenTiketHarian);

    const categories = trenData.map(item => item.tanggal);
    const tiketMasuk = trenData.map(item => item.tiket_masuk);
    const tiketSelesai = trenData.map(item => item.tiket_selesai);

    const optionsTren = {
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [
            { name: 'Tiket Masuk', data: tiketMasuk },
            { name: 'Tiket Selesai', data: tiketSelesai },
        ],
        xaxis: {
            categories,
            labels: { style: { colors: '#6c757d' } },
        },
        yaxis: {
            labels: { style: { colors: '#6c757d' } },
        },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#007bff', '#28a745'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 0.4, opacityFrom: 0.5, opacityTo: 0.1 },
        },
        dataLabels: { enabled: false },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: '#6c757d' },
        },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { theme: 'light' },
    };

    new ApexCharts(document.querySelector("#chartTrenTiketHarian"), optionsTren).render();
</script>
@endpush