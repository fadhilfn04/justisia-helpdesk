<x-default-layout>

    @section('title')
        Daftar Tiket
    @endsection

    <!--begin::Stat Cards-->
    <div class="row g-5 mb-7">
        @php
            $stats = [
                ['label' => 'Semua Tiket', 'count' => 5, 'color' => 'text-gray-800'],
                ['label' => 'Terbuka', 'count' => 1, 'color' => 'text-primary'],
                ['label' => 'Proses', 'count' => 1, 'color' => 'text-warning'],
                ['label' => 'Menunggu', 'count' => 1, 'color' => 'text-info'],
                ['label' => 'Selesai', 'count' => 1, 'color' => 'text-success'],
                ['label' => 'Terlambat', 'count' => 1, 'color' => 'text-danger'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="col-md-2">
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
                    <option>Jakarta Selatan</option>
                    <option>Bandung</option>
                    <option>Surabaya</option>
                    <option>Medan</option>
                    <option>Makassar</option>
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
                <h3 class="fw-bold mb-1">Daftar Tiket (5)</h3>
                <div class="text-muted">Kelola dan pantau semua tiket helpdesk</div>
            </div>
            <button class="btn btn-sm btn-light mt-3 mt-sm-0">
                {!! getIcon('arrows-circle', 'fs-5 me-2') !!}
                Refresh
            </button>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-4">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Table-->

    @push('scripts')
        <script>
        </script>
    @endpush

</x-default-layout>