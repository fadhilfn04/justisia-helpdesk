<div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
    <h4 class="fw-bold mb-1">Kinerja Agen</h4>
    <p class="text-muted mb-4">Performa individual agen helpdesk</p>

    <div class="space-y-3">
        @foreach ($kinerjaAgen as $agent)
            @php
                $initials = collect(explode(' ', $agent['nama']))->map(fn($n) => strtoupper($n[0]))->join('');
            @endphp

            <div class="d-flex align-items-center justify-content-between border rounded-3 p-3 hover:bg-gray-50 transition">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; font-weight: 600;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $agent['nama'] }}</div>
                        <div class="text-muted small">{{ $agent['tiket_selesai'] }} tiket ditangani</div>
                    </div>
                </div>
                <div class="text-end">
                    <div class="fw-semibold">{{ $agent['sla_rata'] }} hari</div>
                    <div class="text-muted small">Rata-rata SLA</div>
                </div>
                <div class="text-end ms-4">
                    <div class="fw-semibold">{{ $agent['rating'] }}/5.0</div>
                    <div class="text-muted small">Rating</div>
                </div>
            </div>
        @endforeach
    </div>
</div>