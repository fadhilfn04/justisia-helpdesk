<x-default-layout>

    @section('title')
        Daftar Pengguna
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

<div class="content-wrapper">
    <div class="container-fluid">

        <div class="d-flex justify-content-end align-items-center mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="openCreateModal()">
                <i class="bi bi-plus-lg"></i> Tambah Pengguna
            </button>
        </div>

        <div class="card mb-7 border-0 shadow-sm">
            <div class="card-body">
                <div class="position-relative">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5 top-50 translate-middle-y text-gray-500') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid ps-13" placeholder="Cari Pengguna..." id="userSearch"/>
                </div>
                <div class="table-responsive">
                    <table id="users" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class=" text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Kontak</th>
                                <th>Departemen</th>
                                <th>Wilayah</th>
                                <th>Status</th>
                                <th>Tiket Ditangani</th>
                                <th>Terakhir Login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="userModalLabel">Tambah Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm">
                <div class="modal-body">
                    @include('pages.admin.user-management._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/custom-js/user-management.js') }}"></script>
@endpush

</x-default-layout>