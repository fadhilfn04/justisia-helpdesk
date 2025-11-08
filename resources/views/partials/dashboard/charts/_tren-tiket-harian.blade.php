<div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
    <h4 class="fw-bold mb-1">Tren Tiket Harian</h4>
    <p class="text-muted mb-4">Perkembangan tiket dan pembatalan per hari</p>
    <div id="chartTrenTiketHarian"></div>
</div>

<!-- Statistik Kinerja -->
<div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
    <h4 class="fw-bold mb-1">Prediksi Beban Kerja</h4>
    <p class="text-muted mb-4">Estimasi tiket masuk bulan depan berdasarkan tren historis</p>
    <div class="row mb-8">
        <div class="col-md">
            <div class="bg-light rounded-3 p-6 h-100 border-dashed">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-6 text-gray-600">Prediksi Tiket Masuk</span>
                    <i class="ki-outline ki-graph fs-2 text-gray-500"></i>
                </div>
                <div class="fs-2hx fw-bold text-gray-800">187</div>
                <div class="fs-7 text-success mt-2">
                    +6% dari bulan ini
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="bg-light rounded-3 p-6 h-100 border-dashed">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-6 text-gray-600">Estimasi Tiket Selesai</span>
                    <i class="ki-outline ki-chart-line-up fs-2 text-gray-500"></i>
                </div>
                <div class="fs-2hx fw-bold text-gray-800">87</div>
                <div class="fs-7 text-success mt-2">
                    90% completion rate
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="bg-light rounded-3 p-6 h-100 border-dashed">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-6 text-gray-600">Kemungkinan Backlog</span>
                    <i class="ki-outline ki-calendar fs-2 text-gray-500"></i>
                </div>
                <div class="fs-2hx fw-bold text-gray-800">18</div>
                <div class="fs-7 text-danger mt-2">
                    Perlu perhatian
                </div>
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
        chart: { type: 'line', height: 320, toolbar: { show: false } },
        series: [
            { name: 'Tiket Masuk', data: tiketMasuk },
            { name: 'Tiket Selesai', data: tiketSelesai }
        ],
        xaxis: { categories },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#008FFB', '#00E396'],
        dataLabels: { enabled: false },
        legend: { position: 'top' },
        grid: { borderColor: '#f1f1f1' },
        tooltip: { theme: 'light' }
    };

    new ApexCharts(document.querySelector("#chartTrenTiketHarian"), optionsTren).render();
</script>
@endpush