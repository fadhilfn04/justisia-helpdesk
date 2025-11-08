document.addEventListener('DOMContentLoaded', function() {

    // helpdesk index js
    let cardStatus = '';
    const userId = $('#formTiket input[name="userPelaporId"]').val();

    // select2
    const statusSelect = $('#statusSelect');
    const prioritasSelect = $('#prioritasSelect');

    const options = [
    { value: '', text: 'Semua Status' },
    { value: 'terbuka', text: 'Terbuka' },
    { value: 'proses', text: 'Proses' },
    { value: 'selesai', text: 'Selesai' },
    { value: 'draft', text: 'Draft' },
    { value: 'revisi', text: 'Perlu Revisi' }
    ];

    const optionsPrioritas = [
    { value: '', text: 'Semua Prioritas' },
    { value: 'rendah', text: 'Rendah' },
    { value: 'sedang', text: 'Sedang' },
    { value: 'tinggi', text: 'Tinggi' },
    ];

    options.forEach(opt => {
        statusSelect.append(new Option(opt.text, opt.value));
    });

    optionsPrioritas.forEach(opt => {
        prioritasSelect.append(new Option(opt.text, opt.value));
    });

    statusSelect.select2({
        placeholder: 'Semua Status',
        allowClear: true,
        width: '100%'
    });

    prioritasSelect.select2({
        placeholder: 'Semua Prioritas',
        allowClear: true,
        width: '100%'
    });

    statusSelect.on('change', function () {
        cardStatus = '';
        $('.card-index-helpdesk').removeClass('border-primary');
        table.ajax.reload();
    });

    prioritasSelect.on('change', function () {
        table.ajax.reload();
    });

    $('#searchTiket').on('keyup', function () {
        table.search(this.value).draw();
    });

    // datatable
    const table = $('#tabel-tiket').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/tiket/api/getTiket',
            data: function (d) {
                d.status = cardStatus || statusSelect.val();
                d.prioritas = prioritasSelect.val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'judul', name: 'title' },
            { data: 'status', name: 'status' },
            { data: 'prioritas', name: 'priority' },
            { data: 'pelapor', name: 'pelapor' },
            { data: 'pj', name: 'pj' },
            { data: 'wilayah', name: 'wilayah' },
            { data: 'sla', name: 'sla' },
            { data: 'respon', name: 'respon' },
            { data: 'aksi', orderable: false, searchable: false },
        ],
        columnDefs: [
            { targets: [1,2,3,4,5,6,7,8], className: 'text-start align-middle' },
            { targets: [0,9], className: 'text-end align-middle' }
        ],
        createdRow: function (row, data, dataIndex) {
            const colorClass = getStatusColor(data.status);
            const td = $('td', row).eq(0);
            td.addClass('td-id-wrapper').html(`
                <span class="status-indicator ${colorClass}"></span>
                ${data.id}
            `);
        },
        drawCallback: function () {
            lucide.createIcons();
        }
    });

    FilePond.registerPlugin(FilePondPluginImagePreview);
    const inputElement = document.querySelector('#fileUpload');

    const pond = FilePond.create(inputElement, {
        allowMultiple: true,
        acceptedFileTypes: ['image/*', 'application/pdf'],
        instantUpload: false,
        allowProcess: false,
        allowRevert: false,
        credits: false,
        labelIdle: `
            <div style="display: flex; cursor: pointer; flex-direction: column; align-items: center; padding-top: 1.5rem; padding-bottom: 1.5rem;">
                <i data-lucide="download" class="mb-3" width="35" height="35"></i>
                <span>Drag & drop files atau <span class="filepond--label-action">Pilih File</span></span>
            </div>
        `,
        fileValidateTypeDetectType: (source, type) => new Promise((resolve) => resolve(type))
    });

    pond.on('init', () => {
        lucide.createIcons();
    });

    // Update preview setiap kali file ditambahkan
    pond.on('addfile', () => {
        updatePdfPreviewArea(pond);
    });

    // Update preview setiap kali file dihapus
    pond.on('removefile', () => {
        updatePdfPreviewArea(pond);
    });

    function updatePdfPreviewArea(pondInstance) {
        const previewArea = document.getElementById('previewArea');
        previewArea.innerHTML = '';

        pondInstance.getFiles().forEach(fileItem => {
            const file = fileItem.file;
            if (file && file.type === 'application/pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = URL.createObjectURL(file);
                iframe.width = '100%';
                iframe.height = '500px';
                iframe.style.border = '1px solid #ccc';
                iframe.classList.add('mb-3');
                previewArea.appendChild(iframe);
            }
        });
    }

    $('#kategori').select2({
        placeholder: 'Pilih Kategori Tiket',
        ajax: {
            url: '/tiket/api/getKategori',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name + ' - ' + item.description
                        };
                    })
                };
            },
            cache: true
        }
    });

    function setSelect2Value(selector, id, text) {
        if (!id || !text) return;

        const option = new Option(text, id, true, true);
        $(selector)
            .append(option)
            .trigger('change.select2');
    }

    $('#createTiketModal').on('shown.bs.modal', function () {
        $('#btnCreateTiket').on('click', function (e) {
            e.preventDefault();

            const title = $('#formTiket input[name="title"]').val()?.trim();
            const deskripsi = $('#formTiket textarea[name="deskripsi"]').val()?.trim();
            const kategori = $('#formTiket select[name="kategori"]').val();
            const fileCount = pond.getFiles().length;

            if (!title || !deskripsi || !kategori || fileCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form belum lengkap',
                    text: 'Pastikan semua data sudah terisi sebelum melanjutkan.',
                });
                return;
            }

            const userId = $('#formTiket input[name="userPelaporId"]').val();
            $.get(`/tiket/api/checkDuplicateTiket/${userId}/${encodeURIComponent(title)}`, function (res) {
                if (res.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tiket sudah tersedia',
                        text: 'Tiket dengan judul yang sama telah tercatat sebelumnya.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Yakin semua data tiket sudah sesuai dan ingin melanjutkan proses ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ajukan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData($('#formTiket')[0]);
                        let maxSize = 10 * 1024 * 1024;
                        let oversizedFiles = [];

                        pond.getFiles().forEach((fileItem, index) => {
                            if (fileItem.file.size > maxSize) {
                                oversizedFiles.push(fileItem.file.name);
                            }
                        });

                        if (oversizedFiles.length > 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ukuran file tidak boleh lebih dari 10MB'
                            });
                            return;
                        }

                        pond.getFiles().forEach((fileItem, index) => {
                            formData.append(`fileTiket[${index}]`, fileItem.file);
                        });

                        formData.append('status', 'open');

                        $('#loaderTiket').show();

                        $.ajax({
                            url: '/tiket/store',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Tiket berhasil diajukan.',
                                });
                                pond.removeFiles();
                                $('#loaderTiket').hide();
                                $("#createTiketModal").modal('hide');
                                $('#formTiket')[0].reset();
                                table.ajax.reload(null, false);
                                refreshStatusSummary();
                            },
                            error: function (xhr) {
                                // console.error(xhr.responseText);
                                if (xhr.status === 422 && xhr.responseJSON?.duplicate) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Tiket sudah tersedia.',
                                        text: xhr.responseJSON.message
                                    });
                                    $('#loaderTiket').hide();
                                    return;
                                }

                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat mengajukan tiket.',
                                });
                                $('#loaderTiket').hide();
                            }
                        });
                    }
                });
            });
        });

        $('#btnDraftTiket').on('click', function (e) {
            e.preventDefault();

            const title = $('#formTiket input[name="title"]').val()?.trim();
            const deskripsi = $('#formTiket textarea[name="deskripsi"]').val()?.trim();
            const kategori = $('#formTiket select[name="kategori"]').val();
            const fileCount = pond.getFiles().length;

            if (!title || !deskripsi || !kategori || fileCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form belum lengkap',
                    text: 'Pastikan semua data sudah terisi sebelum melanjutkan.',
                });
                return;
            }

            $.get(`/tiket/api/checkDuplicateTiket/${userId}/${encodeURIComponent(title)}`, function (res) {
                if (res.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tiket sudah tersedia',
                        text: 'Tiket dengan judul yang sama telah tercatat sebelumnya.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah kamu yakin semua data tiket sudah terisi dengan benar dan ingin menyimpannya sebagai draft?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData($('#formTiket')[0]);
                        let maxSize = 10 * 1024 * 1024;
                        let oversizedFiles = [];

                        pond.getFiles().forEach((fileItem, index) => {
                            if (fileItem.file.size > maxSize) {
                                oversizedFiles.push(fileItem.file.name);
                            }
                        });

                        if (oversizedFiles.length > 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ukuran file tidak boleh lebih dari 10MB'
                            });
                            return;
                        }

                        pond.getFiles().forEach((fileItem, index) => {
                            formData.append(`fileTiket[${index}]`, fileItem.file);
                        });

                        formData.append('status', 'draft');

                        $('#loaderTiket').show();

                        $.ajax({
                            url: '/tiket/store',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Tiket berhasil disimpan sebagai draft.',
                                });
                                pond.removeFiles();
                                $('#loaderTiket').hide();
                                $("#createTiketModal").modal('hide');
                                $('#formTiket')[0].reset();
                                table.ajax.reload(null, false);
                                refreshStatusSummary();
                            },
                            error: function (xhr) {
                                // console.error(xhr.responseText);

                                if (xhr.status === 422 && xhr.responseJSON?.duplicate) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Tiket sudah tersedia.',
                                        text: xhr.responseJSON.message
                                    });
                                    $('#loaderTiket').hide();
                                    return;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat membuat tiket.',
                                });
                                $('#loaderTiket').hide();
                            }
                        });
                    }
                });
            });
        });

        $("#btnEditTiket").on('click', function(e) {
            e.preventDefault();

            const tiketId = $('#formTiket input[name="tiketId"]').val()?.trim();
            const title = $('#formTiket input[name="title"]').val()?.trim();
            const deskripsi = $('#formTiket textarea[name="deskripsi"]').val()?.trim();
            const kategori = $('#formTiket select[name="kategori"]').val();
            const fileCount = pond.getFiles().length;

            if (!tiketId ||!title || !deskripsi || !kategori || fileCount === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form belum lengkap',
                    text: 'Pastikan semua data sudah terisi sebelum melanjutkan.',
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah kamu yakin ingin mengedit data tiket ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, edit',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData($('#formTiket')[0]);
                    let maxSize = 10 * 1024 * 1024;
                    let oversizedFiles = [];

                    pond.getFiles().forEach((fileItem, index) => {
                        if (fileItem.file.size > maxSize) {
                            oversizedFiles.push(fileItem.file.name);
                        }
                    });

                    if (oversizedFiles.length > 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran file tidak boleh lebih dari 10MB'
                        });
                        return;
                    }

                    pond.getFiles().forEach((fileItem, index) => {
                        formData.append(`fileTiket[${index}]`, fileItem.file);
                    });

                    formData.append('isAjukan', 0);

                    $('#loaderTiket').show();

                    $.ajax({
                        url: '/tiket/update',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Tiket berhasil diedit.',
                            });
                            pond.removeFiles();
                            $('#loaderTiket').hide();
                            $("#createTiketModal").modal('hide');
                            $('#formTiket')[0].reset();
                            table.ajax.reload(null, false);
                            refreshStatusSummary();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat megedit tiket.',
                            });
                            $('#loaderTiket').hide();
                        }
                    });
                }
            });
        });

        $("#btnAjukanTiket").on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Setelah tiket diajukan, kamu tidak bisa mengedit data lagi. Yakin ingin melanjutkan proses ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, ajukan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData($('#formTiket')[0]);
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    formData.append('isAjukan', 1);

                    $('#loaderTiket').show();

                    $.ajax({
                        url: '/tiket/update',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Tiket berhasil diajukan.',
                            });
                            pond.removeFiles();
                            $('#loaderTiket').hide();
                            $("#createTiketModal").modal('hide');
                            $('#formTiket')[0].reset();
                            table.ajax.reload(null, false);
                            refreshStatusSummary();
                        },
                        error: function (xhr) {
                            // console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengajukan tiket.',
                            });
                            $('#loaderTiket').hide();
                        }
                    });
                }
            });
        });
    });

    $('#createTiketModal').on('hidden.bs.modal', function () {
        pond.removeFiles();
        $('#formTiket')[0].reset();
        $('#kategori').val(null).trigger('change');
    });

    // btn create tiket modal
    $(document).on('click', '[data-bs-target="#createTiketModal"]', function () {
        $('#formTiket')[0].reset();
        $('#kategori').val(null).trigger('change');
        $('#createTiketModalLabel').text('Buat Tiket Baru');

        $('#btnCreateTiket').show();
        $('#btnDraftTiket').show();
        $('#btnEditTiket').addClass('d-none');

        $('#formTiket :input:not(#nama_lengkap):not(#email):not(#no_telepon)').prop('disabled', false);

        pond.removeFiles();
        $('#previewArea').html('');

        pond.setOptions({
            disabled: false,
            allowBrowse: true,
            allowDrop: true,
            allowPaste: true,
            labelIdle: `
                <div style="display: flex; cursor: pointer; flex-direction: column; align-items: center; padding-top: 1.5rem; padding-bottom: 1.5rem;">
                    <i data-lucide="download" class="mb-3" style="width:35px; height:35px;"></i>
                    <span>Drag & drop files atau <span class="filepond--label-action">Pilih File</span></span>
                </div>
            `
        });

        setTimeout(() => {
            lucide.createIcons();
        }, 50);
    });

    // btn buka respon modal
    $(document).on('click', '.btn-respon', function () {
        const ticketId = $(this).data('id');
        const ticketStatus = $(this).data('status');
        const adminRoleId = $(this).data('admin-role-id');
        const chatArea = $('#chatArea');
        const chatInput = $('#chatInput');

        if(ticketStatus == "draft")
        {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Status tiket kamu masih dalam tahap draft. Silakan ajukan tiket terlebih dahulu untuk memulai diskusi dengan agen.',
            });
            return;
        }

        $('#responModal').modal('show');
        if (adminRoleId == 1) {
            $("#responModalLabel").html("Diskusi terkait <strong>tiket user</strong> dengan agen");
            $('.input-chat-wrapper').addClass('d-none');
        } else {
            $('.input-chat-wrapper').removeClass('d-none');
        }

        chatArea.html('<div class="text-center text-muted mt-4">Memuat pesan...</div>');

        let isFirstLoad = true;

        function loadChat() {
            if (isFirstLoad) {
                chatArea.html(`
                    <div class="p-3">
                        <div class="skeleton mb-3" style="width: 60%; height: 40px;"></div>
                        <div class="skeleton mb-3 ms-auto" style="width: 45%; height: 40px;"></div>
                        <div class="skeleton mb-3" style="width: 70%; height: 40px;"></div>
                        <div class="skeleton mb-3 ms-auto" style="width: 50%; height: 40px;"></div>
                    </div>
                `);
            }

            $.ajax({
                url: `/tiket/getAllChat/${ticketId}`,
                method: 'GET',
                success: function (data) {
                    chatArea.empty();
                    isFirstLoad = false;

                    if (!data || data.length === 0) {
                        chatArea.html('<div class="text-center text-muted mt-4">Belum ada pesan.</div>');
                        return;
                    }

                    data.forEach(msg => {
                        let isRight;

                        if (adminRoleId == 1) {
                            const senderIds = [...new Set(data.map(m => m.sender_id))];
                            const leftId = senderIds[0];
                            isRight = msg.sender_id !== leftId;
                        } else {
                            isRight = msg.sender_id == userId;
                        }

                        const waktu = new Date(msg.created_at).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        let senderName;
                        if (adminRoleId == 1) {
                            senderName = msg.sender?.name || 'Agen';
                        } else {
                            senderName = isRight ? 'Anda' : (msg.sender?.name || 'Agen');
                        }

                        const messageHTML = `
                            <div class="d-flex ${isRight ? 'justify-content-end' : ''} mb-3">
                                <div class="${isRight ? 'bg-primary text-white' : 'bg-white border'} rounded-3 p-3 shadow-sm" style="max-width: 70%; position: relative;">
                                    <strong>${senderName}:</strong><br>
                                    ${msg.message}
                                    <div class="text-end mt-1" style="font-size: 0.75rem; opacity: 0.7;">${waktu}</div>
                                </div>
                            </div>
                        `;
                        chatArea.append(messageHTML);
                    });


                    chatArea.scrollTop(chatArea[0].scrollHeight);
                },
                error: function () {
                    chatArea.html('<div class="text-center text-danger mt-4">Gagal memuat chat.</div>');
                }
            });
        }

        loadChat();
        const chatInterval = setInterval(loadChat, 2000);

        $('#responModal').on('hidden.bs.modal', function () {
            clearInterval(chatInterval);
        });

        $('#sendBtn').off('click').on('click', function () {
            const message = chatInput.val().trim();
            if (!message) return;

            const formData = new FormData();
            formData.append('ticket_id', ticketId);
            formData.append('sender_id', userId);
            formData.append('message', message);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: `/tiket/sendChat`,
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function () {
                    chatInput.val('');
                    loadChat();
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    console.error(xhr.responseJSON);
                    alert('Gagal mengirim pesan.');
                }
            });
        });
    });

    // btn buka detail modal
    $(document).on('click', '.btn-detail', function () {
        const id = $(this).data('id');
        const StatusTiket = $(this).data('status');

        $("#btnAjukanTiket").addClass('d-none');
        if(StatusTiket == "draft")
        {
            $("#btnAjukanTiket").removeClass('d-none');
        }

        $('#createTiketModalLabel').text('Detail Tiket');
        $('#btnCreateTiket').hide();
        $('#btnDraftTiket').hide();
        $('#btnEditTiket').addClass('d-none');
        $('#formTiket :input').not('.tiket-id').not('.user-pelapor-id').prop('disabled', true);

        pond.removeFiles();
        const previewArea = $('#previewArea');
        previewArea.html('');

        $.get(`/tiket/api/getDetailTiket/${id}`, function (res) {
            // Isi form
            $('#judul').val(res.title);
            $('#deskripsi').val(res.description);
            $('#wilayah').val(res.wilayah_id);
            $('.tiket-id').val(res.id);
            setSelect2Value('#kategori', res.category_id, res.category_name);

            const fileList = res.file_ticket?.filter(url => !!url);

            if (fileList.length > 0) {
                pond.setOptions({
                    disabled: true,
                    allowBrowse: false,
                    allowDrop: false,
                    allowPaste: false,
                    labelIdle: ''
                });

                setTimeout(() => {
                    lucide.createIcons();
                }, 50);

                fileList.forEach(fileUrl => {
                    pond.addFile(fileUrl).then(() => {
                        console.log('Preview file lama ditampilkan:', fileUrl);
                    }).catch(err => {
                        console.warn('File gagal dimuat:', fileUrl);
                    });
                });
            } else {
                previewArea.html(`
                    <div class="d-flex flex-column align-items-center justify-content-center text-muted py-4">
                        <i data-lucide="file-x" class="mb-2" style="width:2.5rem;height:2.5rem;"></i>
                        <div class="fw-semibold">File tidak ditemukan</div>
                        <small class="text-secondary">Dokumen belum tersedia untuk tiket ini</small>
                    </div>
                `);
                lucide.createIcons();

                pond.setOptions({
                    disabled: true,
                    allowBrowse: false,
                    allowDrop: false,
                    allowPaste: false,
                    labelIdle: ''
                });
            }
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal memuat detail',
                text: 'Terjadi kesalahan saat mengambil data tiket.'
            });
        });
    });

    // btn buka edit modal
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        $('#createTiketModalLabel').text('Edit Tiket');
        $('#btnCreateTiket').hide();
        $('#btnDraftTiket').hide();
        $('#btnEditTiket').removeClass('d-none');

        $('#formTiket :input:not(#nama_lengkap):not(#email):not(#no_telepon)').prop('disabled', false);

        pond.removeFiles();
        $('#previewArea').html('');

        $.get(`/tiket/api/getDetailTiket/${id}`, function (res) {
            $('#judul').val(res.title);
            $('#deskripsi').val(res.description);
            $('#wilayah').val(res.wilayah_id);
            $('.tiket-id').val(res.id);
            setSelect2Value('#kategori', res.category_id, res.category_name);

            const fileList = Array.isArray(res.file_ticket) ? res.file_ticket : JSON.parse(res.file_ticket || '[]');

            pond.setOptions({
                disabled: false,
                allowBrowse: true,
                allowDrop: true,
                allowPaste: true,
                labelIdle: `
                    <div style="display: flex; cursor: pointer; flex-direction: column; align-items: center; padding-top: 1.5rem; padding-bottom: 1.5rem;">
                        <i data-lucide="download" class="mb-3" style="width:35px; height:35px;"></i>
                        <span>Drag & drop files atau <span class="filepond--label-action">Pilih File</span></span>
                    </div>
                `,
            });

            setTimeout(() => {
                lucide.createIcons();
            }, 50);

            if (fileList.length > 0) {
                fileList.forEach(fileUrl => {
                    pond.addFile(fileUrl).then(() => {
                        console.log('Preview file lama ditampilkan:', fileUrl);
                    }).catch(err => {
                        console.warn('File gagal dimuat, dilewati:', fileUrl);
                    });
                });
            }
        });
    });

    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Hapus Tiket?',
            text: 'Tindakan ini akan menghapus tiket dan semua file terkait. Lanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/tiket/delete',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                        });
                        refreshStatusSummary();
                        table.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Tiket tidak berhasil dihapus.',
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-verifikasi', function (e) {
        e.preventDefault();

        const id = $(this).data('id');

        $.ajax({
            url: `/tiket/${id}`,
            type: 'GET',
            success: function (response) {
                const tiket = response.data;

                $('#tiket-judul').text(tiket.title);
                $('#tiket-kategori').text(tiket.category.description);
                $('#tiket-deskripsi').text(tiket.description);

                if (tiket.lampiran) {
                    $('#tiket-lampiran').html(
                        `<a href="/storage/${tiket.lampiran}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat Lampiran
                        </a>`
                    );
                } else {
                    $('#tiket-lampiran').html('<span class="text-muted">Tidak ada lampiran</span>');
                }

                $('#modalDetailTiket').modal('show');
                $('#btn-verifikasi-final').data('id', id);
                $('#btn-return').data('id', id);
            },
            error: function () {
                Swal.fire('Gagal!', 'Tidak dapat memuat detail tiket.', 'error');
            }
        });
    });

    $('#btn-verifikasi-final').click(function () {
        const id = $(this).data('id');
        const priority = $('#prioritas').val();
        const agent_id = $('#agent_id').val();

        if (!agent_id) {
            Swal.fire('Peringatan', 'Silakan pilih agent terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Verifikasi & Tugaskan Tiket',
            text: `Yakin ingin memverifikasi tiket #${id}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/tiket/${id}/verification`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        priority,
                        agent_id
                    },
                    success: function () {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Tiket berhasil diverifikasi dan ditugaskan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#modalDetailTiket').modal('hide');
                        // $('#tabel-tiket').DataTable().ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat verifikasi tiket.', 'error');
                    }
                });
            }
        });
    });

    $('#btn-return').click(function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Kembalikan Tiket',
            text: 'Yakin ingin mengembalikan tiket ini ke pengguna untuk dilengkapi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/tiket/${id}/return`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Tiket berhasil dikembalikan ke pengguna.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#modalDetailTiket').modal('hide');
                        // $('#tabel-tiket').DataTable().ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat mengembalikan tiket.', 'error');
                    }
                });
            }
        });
    });

    function getStatusColor(statusHtml) {
        const text = $('<div>').html(statusHtml).text().toLowerCase();
        if (text.includes('draft')) return 'bg-primary';
        if (text.includes('proses')) return 'bg-warning';
        if (text.includes('terbuka')) return 'bg-dark-blue';
        if (text.includes('selesai')) return 'bg-success';
        if (text.includes('perlu revisi')) return 'bg-danger';
        return 'bg-secondary';
    }

    function refreshStatusSummary() {
        $.get('/tiket/api/status-summary', function (data) {
            const container = $('.row-status-summary');
            container.empty();

            data.forEach(item => {
                container.append(`
                    <div class="col-md-2 col-6">
                        <div class="card h-100 card-index-helpdesk rounded border p-12 text-center"
                            data-status="${item.key}">
                            <div class="fw-bold fs-1 ${item.color}">${item.count}</div>
                            <div class="fs-7 small">${item.label}</div>
                        </div>
                    </div>
                `);
            });
        });
    }
    refreshStatusSummary();

    $(document).on('click', '.card-index-helpdesk', function () {
        const selected = $(this).data('status') || '';

        $('.card-index-helpdesk').removeClass('border-primary');
        $(this).addClass('border-primary');

        cardStatus = selected === 'semua tiket' ? '' : selected;

        table.ajax.reload();
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

        $.ajax({
            url: `/tiket/${id}`,
            type: 'GET',
            success: function (response) {
                const tiket = response.data;

                $('#tiket-judul').text(tiket.title);
                $('#tiket-kategori').text(tiket.category.description);
                $('#tiket-deskripsi').text(tiket.description);

                if (tiket.lampiran) {
                    $('#tiket-lampiran').html(
                        `<a href="/storage/${tiket.lampiran}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat Lampiran
                        </a>`
                    );
                } else {
                    $('#tiket-lampiran').html('<span class="text-muted">Tidak ada lampiran</span>');
                }

                $('#modalDetailTiket').modal('show');
                $('#btn-verifikasi-final').data('id', id);
                $('#btn-return').data('id', id);
            },
            error: function () {
                Swal.fire('Gagal!', 'Tidak dapat memuat detail tiket.', 'error');
            }
        });
    });

    $('#btn-verifikasi-final').click(function () {
        const id = $(this).data('id');
        const priority = $('#prioritas').val();
        const agent_id = $('#agent_id').val();

        if (!agent_id) {
            Swal.fire('Peringatan', 'Silakan pilih agent terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Verifikasi & Tugaskan Tiket',
            text: `Yakin ingin memverifikasi tiket #${id}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/tiket/${id}/verification`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        priority,
                        agent_id
                    },
                    success: function () {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Tiket berhasil diverifikasi dan ditugaskan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#modalDetailTiket').modal('hide');
                        // $('#tabel-tiket').DataTable().ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat verifikasi tiket.', 'error');
                    }
                });
            }
        });
    });

    $('#btn-return').click(function () {
        const id = $(this).data('id');
        console.log('Verifikasi Data untuk tiket:', id);
        // contoh: buka modal atau redirect
        // window.location.href = `/helpdesk/verifikasi/${id}`;
    });
});
