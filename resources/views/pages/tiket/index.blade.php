<x-default-layout>

    @section('title')
        Daftar Tiket
    @endsection

    <!--begin::Stat Cards-->
    <div class="row g-5 mb-7">
        @php
            $stats = [
                'Semua Tiket' => $ticket->count(),
                'Terbuka'     => $ticket->where('status', 'Terbuka')->count(),
                'Proses'      => $ticket->where('status', 'Proses')->count(),
                'Menunggu'    => $ticket->where('status', 'Menunggu')->count(),
                'Selesai'     => $ticket->where('status', 'Selesai')->count(),
                'Terlambat'   => $ticket->where('status', 'Terlambat')->count(),
            ];

            $colors = [
                'Semua Tiket' => 'text-gray-800',
                'Terbuka'     => 'text-primary',
                'Proses'      => 'text-warning',
                'Menunggu'    => 'text-info',
                'Selesai'     => 'text-success',
                'Terlambat'   => 'text-danger',
            ];
        @endphp

        @foreach ($stats as $label => $count)
            <div class="col-md-2">
                <div class="card border-0 shadow-sm py-6 text-center hover-elevate-up">
                    <div class="fs-2 fw-bold {{ $colors[$label] }}">{{ $count }}</div>
                    <div class="text-muted">{{ $label }}</div>
                </div>
            </div>
        @endforeach
    </div>
    <!--end::Stat Cards-->

    <!--begin::Filter & Action-->
    <div class="card mb-7 border-0 shadow-sm">
        <div class="card-body d-flex flex-wrap align-items-center gap-3">
            <!--begin::Search-->
            <div class="flex-grow-1 position-relative">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5 top-50 translate-middle-y text-gray-500') !!}
                <input type="text" class="form-control form-control-solid ps-13" placeholder="Cari tiket, ID, atau pelapor..." />
            </div>
            <!--end::Search-->

            <!--begin::Filters-->
            <div class="d-flex flex-wrap gap-3">
                <select class="form-select form-select-solid w-auto">
                    <option>Semua Status</option>
                    <option>Terbuka</option>
                    <option>Proses</option>
                    <option>Menunggu</option>
                    <option>Selesai</option>
                    <option>Terlambat</option>
                </select>

                <select class="form-select form-select-solid w-auto">
                    <option>Semua Prioritas</option>
                    <option>Tinggi</option>
                    <option>Sedang</option>
                    <option>Rendah</option>
                </select>

                <select class="form-select form-select-solid w-auto">
                    <option>Semua Wilayah</option>
                    @foreach($ticket->pluck('wilayah')->unique() as $wilayah)
                        <option>{{ $wilayah }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Filters-->

            <!--begin::Buttons-->
            <div class="ms-auto d-flex gap-2">
                <button class="btn btn-light btn-active-light-primary">
                    {!! getIcon('cloud-download', 'fs-4 me-2') !!}
                    Export
                </button>

                <a href="{{ route('tiket.create') }}" class="btn btn-dark">
                    {!! getIcon('plus', 'fs-4 me-2') !!}
                    Buat Tiket
                </a>
            </div>
            <!--end::Buttons-->
        </div>
    </div>
    <!--end::Filter & Action-->

    <!--begin::Table-->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
            <div>
                <h3 class="fw-bold mb-1">Daftar Tiket ({{ $ticket->count() }})</h3>
                <div class="text-muted">Kelola dan pantau semua tiket helpdesk</div>
            </div>
            <button class="btn btn-sm btn-light mt-3 mt-sm-0" onclick="location.reload()">
                {!! getIcon('arrows-circle', 'fs-5 me-2') !!}
                Refresh
            </button>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="tableTicket" class="table align-middle table-row-dashed fs-6 gy-4">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
                            <th>ID Tiket</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Pelapor</th>
                            <th>Penanggung Jawab</th>
                            <th>Wilayah</th>
                            <th>SLA</th>
                            <th>Respon</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ticket as $t)
                            <tr>
                                <td>#TCK-{{ str_pad($t->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $t->title }}</td>
                                <td>
                                    <span class="badge 
                                        {{ match($t->status) {
                                            'open' => 'badge-light-danger',
                                            'in_progress'  => 'badge-light-warning',
                                            'closed'=> 'badge-light-info',
                                            default => 'badge-light-primary',
                                            }
                                        }} d-inline-flex align-items-center">
                                        {!! getIcon(match($t->status) {
                                            'open' => 'cross-circle',
                                            'in_progress' => 'time',
                                            'closed'=> 'check-circle',
                                            default => 'info',
                                        }, 'fs-4 me-2 text-gray-700') !!}
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-light-{{ strtolower($t->priority) }} d-inline-flex align-items-center">
                                        {!! getIcon(match($t->priority) {
                                            'Tinggi' => 'warning-2',
                                            'Sedang' => 'alert',
                                            'Rendah' => 'chevron-down',
                                            default => 'info',
                                        }, 'fs-4 me-2 text-gray-700') !!}
                                        {{ $t->priority }}
                                    </span>
                                </td>
                                <td>{{ $t->reporter }}</td>
                                <td>{{ $t->assignee }}</td>
                                <td>{{ $t->wilayah }}</td>
                                <td>{{ $t->sla }}</td>
                                <td>{{ $t->response }}</td>
                                <td class="text-end">
                                    <a href="{{ route('tiket.show', $t->id) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('eye', 'fs-4 me-1') !!} Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-10">Tidak ada tiket</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Table-->

    @push('scripts')
    <script>
    $(document).ready(function() {
        var table = $('#tableTicket').DataTable({});
    });
    </script>
    @endpush

</x-default-layout>