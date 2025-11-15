<div class="col-md-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <i class="bi bi-ticket-perforated fs-1 text-primary"></i>
            </div>
            <div class="fw-semibold text-muted text-uppercase small">Tiket Aktif</div>
            <h2 id="total-tiket" class="fw-bold text-dark mb-1">
                {{ $ticketStatus['tiket_aktif'] }}
            </h2>
            <span class="text-success fw-semibold d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-up-short"></i>
                +{{ $ticketStatus['tiket_hari_ini'] }} hari ini
            </span>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <i class="bi bi-person-check fs-1 text-success"></i>
            </div>
            <div class="fw-semibold text-muted text-uppercase small">Agen Online</div>
            <h2 id="agen-online" class="fw-bold text-dark mb-1">
                {{ $agenStats['agen_online'] }}
            </h2>
            <span id="total-agen" class="text-muted small">
                dari {{ $agenStats['total_agen'] }} total agen
            </span>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <i class="bi bi-clock-history fs-1 text-warning"></i>
            </div>
            <div class="fw-semibold text-muted text-uppercase small">Rata-Rata Respon</div>
            <h2 id="waktu-respon" class="fw-bold text-dark mb-1">
                {{ $ticketStatus['rata_rata_waktu_respon'] }} jam
            </h2>
            <span class="text-muted small">Waktu tanggapan rata-rata</span>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
            </div>
            <div class="fw-semibold text-muted text-uppercase small">SLA Compliance</div>
            <h2 id="sla-compliance" class="fw-bold text-dark mb-1">
                {{ $ticketStatus['sla_compliance'] }}%
            </h2>
            <span class="text-muted small">Target kepatuhan SLA</span>
        </div>
    </div>
</div>