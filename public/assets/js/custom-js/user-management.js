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
                render: (data, type, row, meta) => `
                    <div class="text-gray-700 fw-semibold">${meta.row + 1}</div>
                `,
                className: 'text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                render: data => `
                    <div class="fw-bold text-gray-900">${data}</div>
                `
            },
            { 
                data: 'role',
                render: data => {
                    if (!data) {
                        return `<span class="badge bg-light text-muted">-</span>`;
                    }

                    let role = data.id;
                    let colorClass = 'bg-light-warning text-warning';

                    switch (role) {
                        case 1:
                            colorClass = 'bg-light-primary text-primary';
                            break;
                        case 2:
                            colorClass = 'bg-light-success text-success';
                            break;
                        case 3:
                            colorClass = 'bg-light-warning text-warning';
                            break;
                        default:
                            colorClass = 'bg-light text-muted';
                    }

                    return `
                        <span class="badge ${colorClass} fw-semibold px-3 py-2 rounded-pill text-capitalize">
                            ${data.name}
                        </span>
                    `;
                }
            },
            { 
                data: 'phone',
                render: (data, type, row) => `
                    <div>
                        <div class="fw-semibold text-gray-800">${data ?? '-'}</div>
                        <div class="text-muted fs-7">${row.email}</div>
                    </div>
                `
            },
            {
                data: 'departemen',
                render: data => `
                    <span class="text-gray-700">${data ?? '-'}</span>
                `
            },
            {
                data: 'wilayah',
                render: data => `
                    <span class="text-gray-700">${data ?? '-'}</span>
                `
            },
            {
                data: 'status',
                render: data => {
                    let badgeClass = 'bg-secondary';
                    let text = 'Tidak diketahui';

                    if (data === 'Aktif') {
                        badgeClass = 'bg-success bg-opacity-10 text-success';
                        text = 'Aktif';
                    } else if (data === 'Nonaktif') {
                        badgeClass = 'bg-danger bg-opacity-10 text-danger';
                        text = 'Nonaktif';
                    }

                    return `
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold ${badgeClass} px-2 py-1 rounded">${text}</span>
                        </div>
                    `;
                }
            },
            {
                data: 'tiket_ditangani',
                render: data => `
                    <span class="text-gray-800 fw-semibold">${data ?? '-'}</span>
                `
            },
            {
                data: 'terakhir_login',
                render: data => `
                    <div class="text-gray-700">${data ?? '-'}</div>
                `
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (data, type, row) => `
                    <div class="dropdown text-center">
                        <button type="button" 
                                class="btn btn-light btn-sm btn-active-light-primary"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-three-dots-vertical fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item btn-edit" href="#" data-id="${row.id}">
                                    <i class="bi bi-pencil-square text-warning me-2"></i>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger btn-delete" href="#" data-id="${row.id}">
                                    <i class="bi bi-trash3-fill text-danger me-2"></i>
                                    Hapus
                                </a>
                            </li>
                        </ul>
                    </div>
                `
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