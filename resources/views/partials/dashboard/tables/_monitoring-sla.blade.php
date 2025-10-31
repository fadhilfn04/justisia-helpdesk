<div class="card shadow-sm border-0">
    <div class="card-header">
        <div class="card-title">
            <h2>Monitoring SLA</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody>
                    @foreach([
                        [
                            'id' => 'TKT-23001',
                            'judul' => 'Sengketa batas tanah di Jakarta Selatan',
                            'status' => 'Peringatan',
                            'badge' => 'bg-warning',
                            'waktu' => '2 jam lalu'
                        ],
                        [
                            'id' => 'TKT-23002',
                            'judul' => 'Konflik kepemilikan tanah di Bandung',
                            'status' => 'Terlambat',
                            'badge' => 'bg-danger',
                            'waktu' => '5 jam lalu'
                        ],
                        [
                            'id' => 'TKT-23003',
                            'judul' => 'Permohonan pembatalan sertifikat ganda',
                            'status' => 'Normal',
                            'badge' => 'bg-success',
                            'waktu' => '1 hari lalu'
                        ],
                        [
                            'id' => 'TKT-23004',
                            'judul' => 'Cacat administrasi sertifikat di Surabaya',
                            'status' => 'Tertunda',
                            'badge' => 'bg-danger',
                            'waktu' => '2 hari lalu'
                        ],
                        [
                            'id' => 'TKT-23005',
                            'judul' => 'Putusan pengadilan atas kasus tanah Medan',
                            'status' => 'Terbuka',
                            'badge' => 'bg-success',
                            'waktu' => '3 hari lalu'
                        ],
                    ] as $tiket)
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-800">{{ $tiket['judul'] }}</div>
                                <div class="text-muted fs-7">ID: {{ $tiket['id'] }}</div>
                            </td>
                            <td class="text-end">
                                <div>
                                    <span class="badge {{ $tiket['badge'] }}">{{ $tiket['status'] }}</span>
                                </div>
                                <div class="text-muted fs-8 mt-1">{{ $tiket['waktu'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>