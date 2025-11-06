<x-default-layout>

<div class="content-wrapper">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Kelola Kategori Tiket</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="openCreateModal()">
                <i class="bi bi-plus-lg"></i> Tambah Kategori Tiket
            </button>
        </div>

        <div class="card border">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ticketCategory" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class=" text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ticketCategoryModal" tabindex="-1" aria-labelledby="ticketCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ticketCategoryModalLabel">Tambah Kategori Tiket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ticketCategoryForm">
                <div class="modal-body">
                    @include('pages.admin.ticket-category._form')
                    <input type="hidden" id="ticket_category_id" name="ticket_category_id">
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
    <script src="{{ asset('assets/js/custom-js/ticket-category.js') }}"></script>
@endpush

</x-default-layout>