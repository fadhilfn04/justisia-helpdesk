$(document).ready(function () {
    $('#userSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#users').DataTable({
        processing: true,
        serverSide: false,
        ajax: '/user-management/users/data',
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
                className: 'text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
            },
            { 
                data: 'role',
                render: data => data ? data.name : '-'
            },
            { 
            data: 'phone',
                render: function (data, type, row) {
                    return data
                        ? `<div class="text-gray-700">${data}</div><div class="text-muted fs-7">${row.email}</div>`
                        : `<div class="text-muted">${row.email}</div>`;
                }
            },
            {
                data: 'departemen',
            },
            {
                data: 'wilayah',
            },
            {
                data: 'status',
            },
            {
                data: 'tiket_ditangani',
            },
            {
                data: 'terakhir_login',
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
        $('#userModalLabel').text('Tambah Pengguna');
        $('#userForm')[0].reset();
        $('#user_id').val('');
        $('#userModal').modal('show');
    };

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        $.get(`/user-management/users/${id}/edit`, function (data) {
            $('#userModalLabel').text('Edit Pengguna');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);

            $('input[name="role_id"]').prop('checked', false);

            if (data.role && data.role.id) {
                $(`input[name="role_id"][value="${data.role.id}"]`).prop('checked', true);
            }

            $('#userModal').modal('show');
        });
    });

    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#user_id').val();
        const url = id ? `/user-management/users/${id}` : `/user-management/users`;
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
                    text: id ? 'Pengguna berhasil diperbarui.' : 'Pengguna berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#userModal').modal('hide');
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
            title: 'Yakin hapus Pengguna ini?',
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
                    url: `/user-management/users/${id}`,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Pengguna berhasil dihapus.',
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