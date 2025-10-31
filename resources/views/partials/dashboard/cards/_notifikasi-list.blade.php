@php
    $colors = [
        'warning' => 'bg-light-warning border-start border-warning border-4',
        'success' => 'bg-light-success border-start border-success border-4',
        'info'    => 'bg-light-info border-start border-info border-4',
        'danger'  => 'bg-light-danger border-start border-danger border-4',
    ];
@endphp

@forelse ($notifications as $notif)
    @php
        $type = $notif->type ?? 'info';
        $colorClass = $colors[$type] ?? $colors['info'];
        $isRead = $notif->is_read == 1;
    @endphp

    <div class="d-flex justify-content-between align-items-start p-4 {{ $colorClass }}">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="fw-bold text-gray-900">{{ $notif->title ?? 'Tanpa Judul' }}</span>

                @if (!empty($notif->badge))
                    <span class="badge badge-light-{{ $type }}">{{ $notif->badge }}</span>
                @endif
            </div>
            <div class="text-muted fs-7">{{ $notif->description ?? 'Tidak ada deskripsi' }}</div>
            <div class="text-gray-500 fs-8 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
        </div>

        <div class="d-flex gap-2">
            @if (!$isRead)
                <form action="{{ route('notifications.markRead', $notif->id) }}" method="POST" class="form-mark-read">
                    @csrf
                    <button type="submit" class="btn btn-icon btn-light btn-sm" title="Tandai dibaca">
                        <i class="ki-duotone ki-check fs-4 text-gray-700"></i>
                    </button>
                </form>
            @endif

            <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="form-delete-notif">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-icon btn-light btn-sm" title="Hapus notifikasi">
                    <i class="ki-duotone ki-cross"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </form>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-10">Tidak ada notifikasi baru</div>
@endforelse