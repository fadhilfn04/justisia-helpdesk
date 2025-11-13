<div class="card shadow-sm border-0 h-100">
    <div class="card-header">
        <div class="card-title">
            <h2>Aktivitas Real Time</h2>
        </div>
    </div>

    <div class="card-body">
        @if ($recentActivities->isEmpty())
            <div class="text-muted text-center py-5">Belum ada aktivitas terkini.</div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($recentActivities as $activity)
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div>
                            <div class="fw-semibold">
                                {{ $activity->ticket_title }}
                            </div>
                            <div class="text-muted small">oleh {{ $activity->actor_name }}</div>
                        </div>
                        <div class="text-end">
                            @php
                                [$badgeClass, $badgeText] = match ($activity->action) {
                                    'draft' => ['bg-primary text-white', 'Draft'],
                                    'open' => ['bg-primary text-white', 'Terbuka'],
                                    'assignee' => ['bg-warning text-white', 'Ditugaskan'],
                                    'in_progress' => ['bg-success text-white', 'Diproses'],
                                    'closed' => ['bg-dark text-white', 'Ditutup'],
                                    'need_revision' => ['bg-danger text-white', 'Butuh Revisi'],
                                    'agent_rejected' => ['bg-danger text-white', 'Ditolak Agent'],
                                    default => ['bg-secondary text-white', ucfirst($activity->action ?? 'Tidak diketahui')],
                                };
                            @endphp

                            <span class="badge {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>

                            <span class="text-muted small">
                                {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>