<div class="card shadow-sm border-0">
    <div class="card-header">
        <div class="card-title">
            <h2>Monitoring SLA</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableSLA" class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody>
                    @forelse($slaMonitoring as $tiket)
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-800">
                                    {{ $tiket['title'] }}
                                </div>
                                <div class="text-muted fs-7">
                                    ID: {{ $tiket['id'] }}
                                </div>
                            </td>
                            <td class="text-end">
                                <div>
                                    <span class="badge {{ $tiket['badge'] }}">
                                        {{ $tiket['status'] }}
                                    </span>
                                </div>
                                <div class="text-muted fs-8 mt-1">
                                    {{ \Carbon\Carbon::parse($tiket['created_at'])->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-5">
                                Tidak ada data tiket saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>