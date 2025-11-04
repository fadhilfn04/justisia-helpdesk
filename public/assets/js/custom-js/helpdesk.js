$(document).ready(function () {

    // helpdesk index js
    function getStatusColor(statusHtml) {
        const text = $('<div>').html(statusHtml).text().toLowerCase();
        if (text.includes('terbuka')) return 'bg-primary';
        if (text.includes('proses')) return 'bg-warning';
        if (text.includes('menunggu')) return 'bg-orange';
        if (text.includes('selesai')) return 'bg-success';
        if (text.includes('terlambat')) return 'bg-danger';
        return 'bg-secondary';
    }

    const table = $('#tabel-tiket').DataTable({
        processing: true,
        serverSide: false,
        data: [
            {
                id: 'TKT-2021-001',
                judul: 'Sengketa batas tanah di Jakarta Selatan',
                description: 'Konflik batas tanah antara dua pemilik yang bersebelahan',
                status: `
                <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 badge-bg-primary">
                    <i data-lucide="triangle-alert" class="text-primary" style="width: 0.95rem;"></i>
                    <span class="text-primary">Terbuka</span>
                </span>
                `,
                prioritas: `
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        Tinggi
                    </span>
                `,
                pelapor: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Sindi Salfa</span>
                    </span>
                `,
                pj: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>Ahmad Fauzi</span>
                    </span>
                `,
                wilayah: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Jakarta Selatan</span>
                    </span>
                `,
                sla: '2 hari 4 jam',
                respon: '<i data-lucide="message-square" class="text-dark" style="width: 1.1rem;"></i> 3',
                aksi: `
                    <button type="button" class="btn-icon">
                        <i data-lucide="ellipsis" class="icon-action"></i>
                    </button>
                `,
            },
            {
                id: 'TKT-2021-002',
                judul: 'Penataan administrasi cacat administrasi',
                description: 'Konflik batas tanah antara dua pemilik yang bersebelahan',
                status: `
                <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 badge-bg-warning">
                    <i data-lucide="clock" class="text-warning" style="width: 0.95rem;"></i>
                    <span class="text-warning">Proses</span>
                </span>
                `,
                prioritas: `
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        Tinggi
                    </span>
                `,
                pelapor: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Rina Mustika</span>
                    </span>
                `,
                pj: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>Dovi Sartika</span>
                    </span>
                `,
                wilayah: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Jakarta Barat</span>
                    </span>
                `,
                sla: '1 hari 8 jam',
                respon: '<i data-lucide="message-square" class="text-dark" style="width: 1.1rem;"></i> 3',
                aksi: `
                    <button type="button" class="btn-icon">
                        <i data-lucide="ellipsis" class="icon-action"></i>
                    </button>
                `,
            },
            {
                id: 'TKT-2021-003',
                judul: 'Konflik kepemilikan tanah warisan',
                description: 'Konflik batas tanah antara dua pemilik yang bersebelahan',
                status: `
                    <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 badge-bg-chocolate">
                        <i data-lucide="clock" style="width: 0.95rem;"></i>
                        <span>Menunggu</span>
                    </span>
                `,
                prioritas: `
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        Sedang
                    </span>
                `,
                pelapor: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Sindi Salfa</span>
                    </span>
                `,
                pj: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>Susi Sartika</span>
                    </span>
                `,
                wilayah: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Jakarta Pusat</span>
                    </span>
                `,
                sla: '5 hari 2 jam',
                respon: '<i data-lucide="message-square" class="text-dark" style="width: 1.1rem;"></i> 3',
                aksi: `
                    <button type="button" class="btn-icon">
                        <i data-lucide="ellipsis" class="icon-action"></i>
                    </button>
                `,
            },
            {
                id: 'TKT-2021-004',
                judul: 'Verifikasi dokumen pengadilan',
                description: 'Konflik batas tanah antara dua pemilik yang bersebelahan',
                status: `
                    <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 badge-bg-success text-success">
                        <i data-lucide="circle-check-big" style="width: 0.95rem;"></i>
                        <span>Selesai</span>
                    </span>
                `,
                prioritas: `
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        Rendah
                    </span>
                `,
                pelapor: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Ahmad Fauzi</span>
                    </span>
                `,
                pj: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>Rina Mustika</span>
                    </span>
                `,
                wilayah: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Jakarta Timur</span>
                    </span>
                `,
                sla: '1 hari 2 jam',
                respon: '<i data-lucide="message-square" class="text-dark" style="width: 1.1rem;"></i> 3',
                aksi: `
                    <button type="button" class="btn-icon">
                        <i data-lucide="ellipsis" class="icon-action"></i>
                    </button>
                `,
            },
            {
                id: 'TKT-2021-005',
                judul: 'Verifikasi dokumen kepemilikan',
                description: 'Konflik batas tanah antara dua pemilik yang bersebelahan',
                status: `
                <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 badge-bg-danger">
                    <i data-lucide="triangle-alert" class="text-danger" style="width: 0.95rem;"></i>
                    <span class="text-danger">Terlambat</span>
                </span>
                `,
                prioritas: `
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        Tinggi
                    </span>
                `,
                pelapor: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Sari Indah</span>
                    </span>
                `,
                pj: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>Ahmad Fauzi</span>
                    </span>
                `,
                wilayah: `
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width: 1.4rem;"></i>
                        <span>Jakarta Selatan</span>
                    </span>
                `,
                sla: '2 hari',
                respon: '<i data-lucide="message-square" class="text-dark" style="width: 1.1rem;"></i> 3',
                aksi: `
                    <button type="button" class="btn-icon">
                        <i data-lucide="ellipsis" class="icon-action"></i>
                    </button>
                `,
            }
        ],
        columns: [
            { data: 'id' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div class="d-flex flex-column">
                            <span class="fw-semibold text-dark">${row.judul}</span>
                            <span class="text-truncate-ellipsis">${row.description}</span>
                        </div>
                    `;
                }
            },
            { data: 'status' },
            { data: 'prioritas' },
            { data: 'pelapor' },
            { data: 'pj' },
            { data: 'wilayah' },
            { data: 'sla' },
            { data: 'respon' },
            { data: 'aksi', orderable: false, searchable: false }
            // {
            //     data: null,
            //     orderable: false,
            //     searchable: false,
            //     render: function (data, type, row) {
            //         return `
            //             <div class="dropdown text-end">
            //                 <button class="btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
            //                     <i data-lucide="ellipsis" class="icon-action"></i>
            //                 </button>
            //                 <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            //                     <li>
            //                         <a class="dropdown-item btn-verifikasi" href="#" data-id="${row.id}">
            //                             <i data-lucide="check-circle" class="me-2"></i> Verifikasi Data
            //                         </a>
            //                     </li>
            //                 </ul>
            //             </div>
            //         `;
            //     }
            // }
        ],
        columnDefs: [
            { targets: [1,2,3,4,5,6,7,8], className: 'text-start' },
            { targets: [0,9], className: 'text-end' }
        ],
        createdRow: function (row, data, dataIndex) {
            const colorClass = getStatusColor(data.status);
            const td = $('td', row).eq(0);
            td.addClass('td-id-wrapper').html(`
                <span class="status-indicator ${colorClass}"></span>
                ${data.id}
            `);
        },
        drawCallback: function(settings) {
            lucide.createIcons();
        }
    });

    $(document).on('click', '.card-index-helpdesk', function () {
        const selectedStatus = $(this).data('status')?.toLowerCase() || '';

        $('.card-index-helpdesk').removeClass('border-primary');
        $(this).addClass('border-primary');

        if (selectedStatus === 'semua tiket' || selectedStatus === '') {
            table.column(2).search('').draw();
            return;
        }

        table.column(2).search(selectedStatus, true, false).draw();
    });

    // helpdesk create js
    document.querySelectorAll('.priority-option').forEach(option => {
        option.addEventListener('click', () => {
        document.querySelectorAll('.priority-option').forEach(o => o.classList.remove('active'));
        option.classList.add('active');
        console.log("Prioritas dipilih:", option.dataset.value);
        });
    });

    $(document).on('click', '.btn-verifikasi', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        console.log('Verifikasi Data untuk tiket:', id);
        // contoh: buka modal atau redirect
        // window.location.href = `/helpdesk/verifikasi/${id}`;
    });
});
