<div class="card shadow-sm border-0 rounded-4 p-4 mb-5 bg-light">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fa-solid fa-user-tie text-primary me-2"></i> Kinerja Agen
            </h4>
            <p class="text-muted mb-0">Performa individual agen helpdesk</p>
        </div>
    </div>

    <div class="list-group list-group-flush" id="kinerjaAgenList">
        @forelse ($kinerjaAgen as $agent)
            @php
                $initials = collect(explode(' ', $agent['nama']))->map(fn($n) => strtoupper($n[0]))->join('');
                $ratingColor = match (true) {
                    $agent['rating'] >= 4.5 => 'text-success',
                    $agent['rating'] >= 3.5 => 'text-warning',
                    default => 'text-danger',
                };
            @endphp

            <div class="list-group-item d-flex align-items-center justify-content-between border-0 px-0 py-3 rounded-3 mb-2 bg-light-hover transition">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 42px; height: 42px;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="fw-semibold text-dark">{{ $agent['nama'] }}</div>
                        <div class="text-muted small">
                            <i class="fa-solid fa-briefcase me-1"></i> {{ $agent['tiket_selesai'] }} tiket ditangani
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <div class="text-end">
                        <div class="fw-semibold text-dark">
                            <i class="fa-regular fa-clock me-1 text-secondary"></i>{{ $agent['sla_rata'] }} hari
                        </div>
                        <div class="text-muted small">Rata-rata SLA</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-semibold {{ $ratingColor }}">
                            <i class="fa-solid fa-star me-1 text-warning"></i>{{ number_format($agent['rating'], 1) }}/5.0
                        </div>
                        <div class="text-muted small">Rating</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="fa-regular fa-face-smile-beam fs-3 mb-2"></i><br>
                Belum ada data kinerja agen.
            </div>
        @endforelse
    </div>
</div>