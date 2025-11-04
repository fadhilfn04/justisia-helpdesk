<div class="card shadow-sm border-0">
    <div class="card-header">
        <div class="card-title">
            <h2>Tiket Terbaru</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody>
                    @foreach($latestTickets as $ticket)
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-800">{{ $ticket['title'] }}</div>
                                <div class="text-muted fs-7">ID: TKT-{{ $ticket['id'] }}</div>
                            </td>
                            <td class="text-end">
                                <div>
                                    @switch($ticket['status'])
                                        @case('open')
                                            <span class="badge badge-light-primary">Terbuka</span>
                                            @break

                                        @case('in_progress')
                                            <span class="badge badge-light-warning">Sedang Diproses</span>
                                            @break

                                        @case('closed')
                                            <span class="badge badge-light-success">Selesai</span>
                                            @break

                                        @default
                                            <span class="badge badge-light-secondary">Tidak Diketahui</span>
                                    @endswitch
                                </div>
                                <div class="text-muted fs-8 mt-1">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>