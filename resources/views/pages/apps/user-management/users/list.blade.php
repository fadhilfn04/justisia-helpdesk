<x-default-layout>

    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <!-- Statistik Atas -->
    <div class="row mb-8">
        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2hx fw-bold text-gray-800">{{ $totalUsers }}</div>
                    <div class="fs-6 text-gray-600 mt-2">Total Pengguna</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2hx fw-bold text-success">3</div>
                    <div class="fs-6 text-gray-600 mt-2">Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2hx fw-bold text-gray-700">1</div>
                    <div class="fs-6 text-gray-600 mt-2">Tidak Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2hx fw-bold text-danger">1</div>
                    <div class="fs-6 text-gray-600 mt-2">Ditangguhkan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Role -->
    <div class="row mb-8">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-danger bg-opacity-10">
                                <i class="ki-outline ki-shield-tick text-danger fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">{{ $totalAdmin }}</div>
                            <div class="fs-6 text-gray-600">Administrator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-primary bg-opacity-10">
                                <i class="ki-outline ki-user text-primary fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">{{ $totalSupervisor }}</div>
                            <div class="fs-6 text-gray-600">Supervisor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-success bg-opacity-10">
                                <i class="ki-outline ki-people text-success fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">{{ $totalOperator }}</div>
                            <div class="fs-6 text-gray-600">Operator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Filter & Action-->
    <div class="card mb-7 border-0 shadow-sm">
        <div class="card-body d-flex flex-wrap align-items-center gap-3">
            <!--begin::Search-->
            <div class="flex-grow-1 position-relative">
                {!! getIcon('magnifier', 'fs-3 position-absolute ms-5 top-50 translate-middle-y text-gray-500') !!}
                <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid ps-13" placeholder="Cari nama..." id="mySearchInput"/>
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
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                Tambah Pengguna
            </button>
            <livewire:user.add-user-modal></livewire:user.add-user-modal>
            <!--end::Buttons-->
        </div>
    </div>
    <!--end::Filter & Action-->

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <h4 class="fw-bold mb-1">Daftar Pengguna</h4>
            </div>
            <!--begin::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['users-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:init', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
            });
            $('#kt_modal_add_user').on('hidden.bs.modal', function () {
                Livewire.dispatch('new_user');
            });
        </script>
    @endpush

</x-default-layout>
