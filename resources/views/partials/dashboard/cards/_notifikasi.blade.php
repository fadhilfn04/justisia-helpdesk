<div class="card shadow-sm border-0" id="notifikasi-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title mb-0">Notifikasi</h3>
            <span class="text-muted fs-7">Update dan peringatan sistem terbaru</span>
        </div>
        <button id="btn-mark-all-read" class="btn btn-primary btn-sm">Tandai Semua Dibaca</button>
    </div>

    <div class="card-body p-0" id="notifikasi-container">
        @include('partials.dashboard.cards._notifikasi-list', ['notifications' => $notifications])
    </div>
</div>

@push('scripts')
<script>
$(function () {
    function updateMarkAllButton() {
        // cek apakah ada notifikasi yang belum dibaca di container
        if ($('#notifikasi-container .form-mark-read').length > 0) {
            $('#btn-mark-all-read').show();
        } else {
            $('#btn-mark-all-read').hide();
        }
    }

    function reloadNotifikasi() {
        $('#notifikasi-container').html(
            '<div class="text-center py-10 text-muted">Memuat notifikasi...</div>'
        );
        $.get('{{ route('notifications.partial') }}', function (html) {
            $('#notifikasi-container').html(html);
            updateMarkAllButton(); // cek tombol setelah reload
        });
    }

    $('#btn-mark-all-read').on('click', function (e) {
        e.preventDefault();
        $.post('{{ route('notifications.markAllRead') }}', {_token: '{{ csrf_token() }}'}, function () {
            reloadNotifikasi();
        });
    });

    // handle mark single read via AJAX
    $(document).on('submit', '.form-mark-read', function(e) {
        e.preventDefault();
        let form = $(this);
        $.post(form.attr('action'), form.serialize(), function() {
            reloadNotifikasi();
        });
    });

    // handle delete via AJAX
    $(document).on('submit', '.form-delete-notif', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'DELETE',
            data: form.serialize(),
            success: function() {
                reloadNotifikasi();
            }
        });
    });

    // cek tombol saat tab notifikasi dibuka
    $('a[data-bs-toggle="tab"][href="#tab_notifikasi"]').on('shown.bs.tab', reloadNotifikasi);

    // inisialisasi tombol
    updateMarkAllButton();
});
</script>
@endpush