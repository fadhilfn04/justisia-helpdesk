<div class="card shadow-sm rounded-4 p-4 mb-6 bg-white border-0">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Tren Tiket Harian</h4>
            <p class="text-muted mb-0">Perkembangan tiket dan penyelesaian per hari</p>
        </div>
    </div>
    <hr class="my-4 text-muted opacity-25">
    <div id="trenTiketHarianChart"></div>
</div>

<!-- Statistik Kinerja -->
<div class="card shadow-sm rounded-4 p-4 mb-6 bg-white border-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Prediksi Beban Kerja</h4>
            <p class="text-muted mb-0">Estimasi berdasarkan tren historis 3 bulan terakhir</p>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-graph fs-2x text-primary mb-3"></i>
                <div class="fs-1 fw-bold text-dark" data-field="prediksi_tiket_masuk">{{ $statistikKinerja['prediksi_tiket_masuk'] }}</div>
                <div class="fs-7 text-muted mb-1">Prediksi Tiket Masuk</div>
                <span data-field="growwth" class="badge {{ $statistikKinerja['growth'] >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $statistikKinerja['growth'] >= 0 ? 'success' : 'danger' }} fs-8">
                    {{ $statistikKinerja['growth'] >= 0 ? '+' : '' }}{{ $statistikKinerja['growth'] }}% dari bulan ini
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-chart-line-up fs-2x text-success mb-3"></i>
                <div class="fs-1 fw-bold text-dark" data-field="prediksi_selesai">{{ $statistikKinerja['prediksi_selesai'] }}</div>
                <div class="fs-7 text-muted mb-1">Estimasi Tiket Selesai</div>
                <span class="badge bg-success bg-opacity-10 text-success fs-8" data-field="completion_rate">
                    {{ $statistikKinerja['completion_rate'] }}% completion rate
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-light rounded-4 border border-dashed p-4 h-100 text-center">
                <i class="ki-outline ki-calendar fs-2x text-danger mb-3"></i>
                <div class="fs-1 fw-bold text-dark" data-field="backlog">{{ $statistikKinerja['backlog'] }}</div>
                <div class="fs-7 text-muted mb-1">Kemungkinan Backlog</div>
                <span class="badge bg-danger bg-opacity-10 text-danger fs-8" data-field="backlog">
                    {{ $statistikKinerja['backlog'] > 0 ? 'Perlu perhatian' : 'Stabil' }}
                </span>
            </div>
        </div>
    </div>
</div>