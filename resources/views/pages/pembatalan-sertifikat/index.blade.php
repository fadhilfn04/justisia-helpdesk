<x-default-layout>

    @section('title')
        Daftar Tiket
    @endsection

    <!--begin::Stat Cards-->
    <div class="row mb-7">
        @php
            $stats = [
                ['label' => 'Total', 'count' => 5, 'color' => 'text-gray-800'],
                ['label' => 'Menunggu', 'count' => 1, 'color' => 'text-primary'],
                ['label' => 'Proses', 'count' => 1, 'color' => 'text-warning'],
                ['label' => 'Disetujui', 'count' => 1, 'color' => 'text-info'],
                ['label' => 'Selesai', 'count' => 1, 'color' => 'text-danger'],
            ];

            $pembatalanList = [
                [
                    'id_pembatalan' => 'PB-001',
                    'no_sertifikat' => 'SRT-2024-00123',
                    'pemilik' => 'Ahmad Fadillah',
                    'lokasi' => 'Jakarta Selatan',
                    'jenis' => 'Tanah',
                    'status' => 'Proses',
                    'penanggung_jawab' => 'Rina Kartika',
                    'target_selesai' => '2025-11-05',
                ],
                [
                    'id_pembatalan' => 'PB-002',
                    'no_sertifikat' => 'SRT-2024-00456',
                    'pemilik' => 'Satria Nugraha',
                    'lokasi' => 'Bandung',
                    'jenis' => 'Bangunan',
                    'status' => 'Selesai',
                    'penanggung_jawab' => 'Andi Wijaya',
                    'target_selesai' => '2025-10-15',
                ],
                [
                    'id_pembatalan' => 'PB-003',
                    'no_sertifikat' => 'SRT-2024-00789',
                    'pemilik' => 'Dewi Lestari',
                    'lokasi' => 'Surabaya',
                    'jenis' => 'Tanah & Bangunan',
                    'status' => 'Ditolak',
                    'penanggung_jawab' => 'Rudi Hartono',
                    'target_selesai' => '2025-09-28',
                ],
                [
                    'id_pembatalan' => 'PB-004',
                    'no_sertifikat' => 'SRT-2024-00234',
                    'pemilik' => 'Lina Marlina',
                    'lokasi' => 'Medan',
                    'jenis' => 'Tanah',
                    'status' => 'Menunggu',
                    'penanggung_jawab' => 'Fajar Prasetyo',
                    'target_selesai' => '2025-11-10',
                ],
                [
                    'id_pembatalan' => 'PB-005',
                    'no_sertifikat' => 'SRT-2024-00678',
                    'pemilik' => 'Rizky Amelia',
                    'lokasi' => 'Yogyakarta',
                    'jenis' => 'Bangunan',
                    'status' => 'Selesai',
                    'penanggung_jawab' => 'Andi Wijaya',
                    'target_selesai' => '2025-08-30',
                ],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="col">
                <div class="card border-0 shadow-sm py-6 text-center hover-elevate-up">
                    <div class="fs-2 fw-bold {{ $stat['color'] }}">{{ $stat['count'] }}</div>
                    <div class="text-muted">{{ $stat['label'] }}</div>
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
                <input type="text" class="form-control form-control-solid ps-13" placeholder="Cari nomor sertifikat, pemilik, atau lokasi..." />
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
                    <option>Semua Jenis</option>
                    <option>Tinggi</option>
                    <option>Sedang</option>
                    <option>Rendah</option>
                </select>
            </div>
            <!--end::Filters-->

            <!--begin::Buttons-->
            <a href="{{ route('tiket.create') }}" class="btn btn-dark">
                {!! getIcon('plus', 'fs-4 me-2') !!}
                Ajukan Pembatalan
            </a>
            <!--end::Buttons-->
        </div>
    </div>
    <!--end::Filter & Action-->

    <!--begin::Table-->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
            <div>
                <h3 class="fw-bold mb-1">Daftar Pembatalan Sertifikat ({{ count($pembatalanList) }})</h3>
                <div class="text-muted">Kelola proses pembatalan sertifikat berdasarkan cacat administrasi dan putusan pengadilan</div>
            </div>
            <button class="btn btn-sm btn-light mt-3 mt-sm-0">
                {!! getIcon('arrows-circle', 'fs-5 me-2') !!}
                Refresh
            </button>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="pembatalanSertifikat" class="table align-middle table-row-dashed fs-6 gy-4">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
                            <th>ID Pembatalan</th>
                            <th>No. Sertifikat</th>
                            <th>Pemilik</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Penanggung Jawab</th>
                            <th>Target Selesai</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->no_sertifikat }}</td>
                                <td>{{ $item->pemilik }}</td>
                                <td>{{ $item->lokasi }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'Selesai' ? 'success' : ($item->status == 'Proses' ? 'warning' : 'danger') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>{{ $item->penanggung_jawab ?? '-' }}</td>
                                <td>{{ $item->target_selesai ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="#"
                                    class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                        Aksi
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                    </a>

                                    <!--begin::Dropdown menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 
                                                menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                <i class="ki-duotone ki-pencil fs-5 me-2 text-warning"></i>Edit
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                <i class="ki-duotone ki-trash fs-5 me-2 text-danger"></i>Hapus
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Dropdown menu-->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Table-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#pembatalanSertifikat').DataTable({
                    scrollX: true,
                    scrollCollapse: true,
                    paging: true,
                    columnDefs: [
                        { className: 'text-center', targets: '_all' },
                        { orderable: false, targets: -1 }
                    ],
                });
            });
        </script>
    @endpush

</x-default-layout>