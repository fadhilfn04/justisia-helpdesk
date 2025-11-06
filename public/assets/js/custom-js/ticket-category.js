$(document).ready(function () {
    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#ticketCategory').DataTable({
        processing: true,
        serverSide: false,
        ajax: '/settings/ticket-category/data',
        columns: [
            { data: 'id' },
            {
                data: 'name',
            },
            {
                data: 'description',
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="dropdown">
                            <button
                                type="button"
                                class="btn btn-light btn-sm btn-active-light-primary"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ki-outline ki-dots-vertical fs-2"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item btn-edit" href="#" data-id="${row.id}">
                                        <i class="ki-outline ki-pencil fs-5 me-2 text-warning"></i>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger btn-delete" href="#" data-id="${row.id}">
                                        <i class="ki-outline ki-trash fs-5 me-2 text-danger"></i>
                                        Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function () {
            lucide.createIcons();
        }
    });

    window.openCreateModal = function () {
        $('#ticketCategoryModalLabel').text('Tambah Kategori Tiket');
        $('#ticketCategoryForm')[0].reset();
        $('#ticket_category_id').val('');
        $('#ticketCategoryModal').modal('show');
    };

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        $.get(`/settings/ticket-category/${id}/edit`, function (data) {
            $('#ticketCategoryModalLabel').text('Edit Kategori Tiket');
            $('#ticket_category_id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('#ticketCategoryModal').modal('show');
        });
    });

    $('#ticketCategoryForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#ticket_category_id').val();
        const url = id ? `/settings/ticket-category/${id}` : `/settings/ticket-category`;
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: id ? 'Kategori Tiket berhasil diperbarui.' : 'Kategori Tiket berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#ticketCategoryModal').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, coba lagi.'
                });
            }
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus Kategori Tiket ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/settings/ticket-category/${id}`,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Kategori Tiket berhasil dihapus.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Tidak dapat menghapus data.'
                        });
                    }
                });
            }
        });
    });
});