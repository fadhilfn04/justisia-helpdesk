<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-0">Notifikasi</h3>
            <span class="text-muted fs-7">Update dan peringatan sistem terbaru</span>
        </div>
        <button class="btn btn-light btn-sm">Tandai Semua Dibaca</button>
    </div>

    <div class="card-body p-0">
        @php
            $notifications = [
                [
                    'type' => 'warning',
                    'title' => 'SLA Hampir Terlewat',
                    'desc' => 'Tiket TKT-2024-001 akan melewati batas SLA dalam 2 jam',
                    'time' => '29 menit lalu',
                    'badge' => 'Perlu Tindakan'
                ],
                [
                    'type' => 'success',
                    'title' => 'Pembatalan Sertifikat Disetujui',
                    'desc' => 'Sertifikat SRT-789012/2023 telah berhasil dibatalkan',
                    'time' => '39 menit lalu',
                    'badge' => null
                ],
                [
                    'type' => 'info',
                    'title' => 'Tiket Baru Masuk',
                    'desc' => 'Sengketa batas tanah di Jakarta Selatan memerlukan penanganan',
                    'time' => '54 menit lalu',
                    'badge' => null
                ],
                [
                    'type' => 'danger',
                    'title' => 'Sistem Maintenance',
                    'desc' => 'Sistem akan maintenance pada 23:00 - 01:00 WIB',
                    'time' => '1 jam lalu',
                    'badge' => 'Perlu Tindakan'
                ],
            ];

            $colors = [
                'warning' => 'bg-light-warning border-start border-warning border-4',
                'success' => 'bg-light-success border-start border-success border-4',
                'info' => 'bg-light-info border-start border-info border-4',
                'danger' => 'bg-light-danger border-start border-danger border-4',
            ];
        @endphp

        @foreach ($notifications as $notif)
            <div class="d-flex justify-content-between align-items-start p-4 {{ $colors[$notif['type']] }}">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="fw-bold text-gray-900">{{ $notif['title'] }}</span>
                        @if ($notif['badge'])
                            <span class="badge badge-light-{{ $notif['type'] }}">{{ $notif['badge'] }}</span>
                        @endif
                    </div>
                    <div class="text-muted fs-7">{{ $notif['desc'] }}</div>
                    <div class="text-gray-500 fs-8 mt-1">{{ $notif['time'] }}</div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-icon btn-light btn-sm" title="Tandai dibaca">
                        <i class="ki-duotone ki-check fs-4 text-gray-700"></i>
                    </button>
                    <button class="btn btn-icon btn-light btn-sm" title="Hapus notifikasi">
                        <i class="ki-duotone ki-cross">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>