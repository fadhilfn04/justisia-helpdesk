<div class="row mb-8">
    <div class="col-md-3">
        <div class="bg-light rounded-3 p-6 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fs-6 text-gray-600">Total Tiket</span>
                <i class="ki-outline ki-graph fs-2 text-gray-500"></i>
            </div>
            <div class="fs-2hx fw-bold text-gray-800">{{ $statistik['total_tiket'] }}</div>
            <div class="fs-7 text-success mt-2">
                +12% <span class="text-gray-600">dari periode sebelumnya</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="bg-light rounded-3 p-6 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fs-6 text-gray-600">Tingkat Penyelesaian</span>
                <i class="ki-outline ki-chart-line-up fs-2 text-gray-500"></i>
            </div>
            <div class="fs-2hx fw-bold text-gray-800">{{ $statistik['tingkat_penyelesaian'] }} %</div>
            <div class="fs-7 text-success mt-2">
                +2.1% <span class="text-gray-600">dari periode sebelumnya</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="bg-light rounded-3 p-6 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fs-6 text-gray-600">Rata-rata Waktu Respon</span>
                <i class="ki-outline ki-calendar fs-2 text-gray-500"></i>
            </div>
            <div class="fs-2hx fw-bold text-gray-800">{{ $statistik['rata_rata_waktu_respon'] }} <span class="fs-3">hari</span></div>
            <div class="fs-7 text-danger mt-2">
                -0.3 hari <span class="text-gray-600">dari periode sebelumnya</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="bg-light rounded-3 p-6 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fs-6 text-gray-600">SLA Compliance</span>
                <i class="ki-outline ki-time fs-2 text-gray-500"></i>
            </div>
            <div class="fs-2hx fw-bold text-gray-800">{{ $statistik['sla_compliance'] }} %</div>
            <div class="fs-7 text-success mt-2">
                +1.5% <span class="text-gray-600">dari periode sebelumnya</span>
            </div>
        </div>
    </div>
</div>