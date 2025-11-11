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
                                {{ ucfirst($activity->action ?? 'Aktivitas') }}: {{ $activity->ticket_title }}
                            </div>
                            <div class="text-muted small">oleh {{ $activity->actor_name }}</div>
                        </div>
                        <div class="text-end">
                            @php
                                $badgeClass = match ($activity->action) {
                                    'Ticket Created' => 'bg-primary text-white',
                                    'Assigned To Staff' => 'bg-warning text-dark',
                                    'Status Updated' => 'bg-secondary',
                                    'Closed' => 'bg-success text-white',
                                    'Reopened' => 'bg-info text-white',
                                    default => 'bg-secondary'
                                };
                            @endphp

                            <span class="badge {{ $badgeClass }} me-2">
                                {{ $activity->action }}
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