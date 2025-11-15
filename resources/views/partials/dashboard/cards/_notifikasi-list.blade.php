@php
    $colors = [
        'warning' => 'bg-light-warning border-start border-warning border-4',
        'success' => 'bg-light-success border-start border-success border-4',
        'info'    => 'bg-light-info border-start border-info border-4',
        'danger'  => 'bg-light-danger border-start border-danger border-4',
    ];
@endphp

<div class="shadow-sm overflow-hidden">
    @forelse ($notifications as $notif)
        @php
            $type = $notif->type ?? 'info';
            $colorClass = $colors[$type] ?? $colors['info'];
            $isRead = $notif->is_read == 1;
        @endphp

        <div class="{{ $colorClass }} px-4 py-3 d-flex justify-content-between align-items-start position-relative notification-item">
            <div>
                <div class="d-flex align-items-center mb-1 gap-2">
                    <i class="bi bi-bell-fill small text-{{ $type }}"></i>
                    <span class="fw-semibold text-dark">{{ $notif->title ?? 'Tanpa Judul' }}</span>
                    @if (!$isRead)
                        <span class="badge bg-{{ $type }} bg-opacity-25 text-{{ $type }} fw-normal small ms-1">Baru</span>
                    @endif
                </div>

                <div class="text-muted small lh-sm">
                    {!! $notif->message ?? '<em>Tidak ada deskripsi</em>' !!}
                </div>

                <div class="text-gray-500 small mt-2 d-flex align-items-center gap-1">
                    <i class="bi bi-clock-history small"></i>
                    <span>{{ $notif->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="d-flex flex-shrink-0 align-items-start gap-1 ms-3">
                @if (!$isRead)
                    <form action="{{ route('notifications.markRead', $notif->id) }}" method="POST" class="form-mark-read">
                        @csrf
                        <button type="submit" class="btn btn-light-success btn-sm rounded-circle" title="Tandai dibaca">
                            <i class="bi bi-check2 fw-bold"></i>
                        </button>
                    </form>
                @endif

                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="form-delete-notif">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light-danger btn-sm rounded-circle" title="Hapus notifikasi">
                        <i class="bi bi-x-lg fw-bold"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
            Tidak ada notifikasi baru
        </div>
    @endforelse
</div>