<x-default-layout>

    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card mb-5">
        <div class="card-body">

            <!-- Statistik Atas -->
            <div class="row mb-8">
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-6 text-center h-100">
                        <div class="fs-2hx fw-bold text-gray-800">5</div>
                        <div class="fs-6 text-gray-600 mt-2">Total Pengguna</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-6 text-center h-100">
                        <div class="fs-2hx fw-bold text-success">3</div>
                        <div class="fs-6 text-gray-600 mt-2">Aktif</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-6 text-center h-100">
                        <div class="fs-2hx fw-bold text-gray-700">1</div>
                        <div class="fs-6 text-gray-600 mt-2">Tidak Aktif</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-6 text-center h-100">
                        <div class="fs-2hx fw-bold text-danger">1</div>
                        <div class="fs-6 text-gray-600 mt-2">Ditangguhkan</div>
                    </div>
                </div>
            </div>

            <!-- Statistik Role -->
            <div class="row mb-8">
                <div class="col-md-4">
                    <div class="d-flex align-items-center bg-light rounded-3 p-6 h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-danger bg-opacity-10">
                                <i class="ki-outline ki-shield-tick text-danger fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">1</div>
                            <div class="fs-6 text-gray-600">Administrator</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-center bg-light rounded-3 p-6 h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-primary bg-opacity-10">
                                <i class="ki-outline ki-user text-primary fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">1</div>
                            <div class="fs-6 text-gray-600">Supervisor</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-center bg-light rounded-3 p-6 h-100">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label bg-success bg-opacity-10">
                                <i class="ki-outline ki-people text-success fs-2"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-gray-800">3</div>
                            <div class="fs-6 text-gray-600">Operator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add User
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal-->
                <livewire:user.add-user-modal></livewire:user.add-user-modal>
                <!--end::Modal-->
            </div>
            <!--end::Card toolbar-->
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
