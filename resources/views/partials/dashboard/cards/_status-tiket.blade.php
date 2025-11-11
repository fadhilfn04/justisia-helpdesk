<div class="col-md-3 col-sm-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
            <div class="fw-bold text-gray-700 mb-2">Tiket Aktif</div>
            <h2 id="total-tiket" class="fw-bolder text-dark">{{ $ticketStatus['total_tiket'] }}</h2>
            <span class="text-success fw-semibold">+{{ $ticketStatus['tiket_hari_ini'] }} hari ini</span>            
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
            <div class="fw-bold text-gray-700 mb-2">Agen Online</div>
            <h2 id="agen-online" class="fw-bolder text-dark">{{ $agenStats['agen_online'] }}</h2>
            <span id="total-agen" class="text-muted">dari {{ $agenStats['total_agen'] }} total agen</span>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
            <div class="fw-bold text-gray-700 mb-2">Rata-rata Respon</div>
            <h2 id="waktu-respon" class="fw-bolder text-dark">{{ $ticketStatus['rata_rata_waktu_respon'] }}</h2>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-body text-center">
            <div class="fw-bold text-gray-700 mb-2">SLA Compliance</div>
            <h2 id="sla-compliance" class="fw-bolder text-dark">{{ $ticketStatus['sla_compliance'] }} %</h2>
            <div class="progress mt-2" style="height: 6px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 85%;"></div>
            </div>
        </div>
    </div>
</div>