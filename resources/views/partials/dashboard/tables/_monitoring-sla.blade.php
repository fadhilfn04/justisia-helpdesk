<div class="card shadow-sm border-0 mb-4">
    <div class="card-header border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h2 class="card-title fw-semibold text-gray-800 mb-0">Monitoring SLA</h2>
        <span class="badge bg-light text-muted fs-8">
            {{ count($slaMonitoring) }} tiket terakhir
        </span>
    </div>

    <div class="card-body pb-0">
        @if($slaMonitoring->isEmpty())
            <div class="text-center text-muted py-5">
                <i data-lucide="inbox" class="mb-2" style="width: 2rem; height: 2rem;"></i><br>
                Tidak ada data tiket saat ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed gy-4 mb-0">
                    <tbody>
                        @foreach($slaMonitoring as $tiket)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div>
                                            <div class="fw-semibold text-gray-800 fs-6 mb-1">
                                                {{ $tiket['title'] }}
                                            </div>
                                            <div class="text-muted fs-8">
                                                ID: {{ $tiket['id'] }} &nbsp;·&nbsp;
                                                Dibuat {{ \Carbon\Carbon::parse($tiket['created_at'])->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="badge {{ $tiket['badge'] }} fs-7 px-3 py-2">
                                        {{ $tiket['status'] }}
                                    </span>
                                    <div class="text-muted fs-8 mt-1">
                                        Deadline: {{ \Carbon\Carbon::parse($tiket['deadline'])->format('d M H:i') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>