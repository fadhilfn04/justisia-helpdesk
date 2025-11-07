$(document).ready(function () {
    $('#faqSearch').on('keyup', function () {
        table.search(this.value).draw();
    });
    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#faqTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: '/settings/faq/data',
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
                data: 'question',
            },
            {
                data: 'answer',
            },
            {
                data: 'category',
                render: function (data) {
                    // Warna default
                    let badgeClass = 'border-gray-300 text-dark bg-transparent';

                    switch (data?.id) {
                        case 1:
                            badgeClass = 'border-primary text-primary bg-light-primary';
                            break;
                        case 2:
                            badgeClass = 'border-warning text-warning bg-light-warning';
                            break;
                        case 3:
                            badgeClass = 'border-danger text-danger bg-light-danger';
                            break;
                    }

                    return `
                        <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border fw-semibold ${badgeClass}">
                            ${data?.name ?? '-'}
                        </span>
                    `;
                }
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
        columnDefs: [
            { targets: [0], className: 'text-end fw-semibold' },
            { targets: [1, 2], className: 'text-start' },
            { targets: [3], className: 'text-center' }
        ],
        drawCallback: function () {
            lucide.createIcons();
        }
    });

    window.openCreateModal = function () {
        $('#faqModalLabel').text('Tambah FAQ');
        $('#faqForm')[0].reset();
        $('#faq_id').val('');
        $('#faqModal').modal('show');
    };

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        $.get(`/settings/faq/${id}/edit`, function (data) {
            $('#faqModalLabel').text('Edit FAQ');
            $('#faq_id').val(data.id);
            $('#question').val(data.question);
            $('#answer').val(data.answer);
            $('#category_id').val(data.category_id);
            $('#faqModal').modal('show');
        });
    });

    $('#faqForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#faq_id').val();
        const url = id ? `/settings/faq/${id}` : `/settings/faq`;
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
                    text: id ? 'FAQ berhasil diperbarui.' : 'FAQ berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#faqModal').modal('hide');
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
            title: 'Yakin hapus FAQ ini?',
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
                    url: `/settings/faq/${id}`,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'FAQ berhasil dihapus.',
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