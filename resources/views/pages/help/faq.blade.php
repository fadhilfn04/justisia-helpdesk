<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/help.css') }}">

<div class="container">
    <div class="mx-auto" style="max-width: 900px;">
        <!-- Card FAQ Header -->
        <div class="card bg-light border border-gray-300">
            <div class="card-body">
                <div class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                        <i data-lucide="message-circle" class="text-dark"></i>
                        <h1 class="fw-bold text-dark mb-0">Frequently Asked Questions</h1>
                    </div>
                    <div class="fs-6 mb-8">
                        Temukan jawaban untuk pertanyaan yang sering diajukan seputar sistem Justisia
                    </div>
                    <div class="d-flex align-items-center position-relative w-100">
                        {!! getIcon('magnifier','fs-3 position-absolute ms-5') !!}
                        <input type="text" class="form-control input-soft-shadow bg-light ps-13" placeholder="Cari pertanyaan atau topik..." id="faqSearchInput"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-start gap-2 mt-5">
            <button class="btn btn-dark btn-sm fw-semibold px-3 py-1 filter-btn" data-target="all">Semua Laporan</button>
            <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn" data-target="helpdesk"><i data-lucide="ticket" style="width: 1.2rem;"></i> Helpdesk</button>
            <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn" data-target="cancel"><i data-lucide="file-x" style="width: 1.2rem;"></i> Pembatalan Sertifikat</button>
            <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn" data-target="sengketa"><i data-lucide="scale" style="width: 1.2rem;"></i> Sengketa & Konflik</button>
            <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn" data-target="laporan"><i data-lucide="chart-column" style="width: 1.2rem;"></i> Laporan & Statistik</button>
            <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn" data-target="manajemen"><i data-lucide="users-round" style="width: 1.2rem;"></i> Manajemen User</button>
        </div>

        <!-- Card Konten FAQ Helpdesk -->
        <div class="card bg-light border border-gray-300 mt-5" data-category="helpdesk">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 25%;">
                            <i data-lucide="ticket" class="text-white"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Helpdesk</h3>
                    </div>
                    <span class="badge bg-light fs-7 px-3 py-1 mx-3" style="border: 1px solid rgba(108, 117, 125, 0.4);">
                        3 FAQ
                    </span>
                </div>

                <div class="accordion mt-12" id="faqAccordionHelpdesk">
                    <!-- FAQ 1 -->
                    <div class="accordion-item bg-light" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingHelpdeskOne">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseHelpdeskOne"
                                aria-expanded="false"
                                aria-controls="collapseHelpdeskOne">
                                <span class="accordion-text">Bagaimana cara membuat tiket helpdesk baru?</span>
                            </button>
                        </h2>
                        <div id="collapseHelpdeskOne" class="accordion-collapse collapse"
                        aria-labelledby="headingHelpdeskOne"
                        data-bs-parent="#faqAccordionHelpdesk">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Untuk membuat tiket helpdesk baru: 1) Klik menu 'Helpdesk' di sidebar, 2) Pilih 'Buat Tiket', 3) Isi formulir dengan lengkap termasuk kategori, prioritas, dan deskripsi masalah, 4) Upload dokumen pendukung jika diperlukan, 5) Klik 'Submit Tiket'. Anda akan mendapat nomor tiket untuk tracking.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item bg-light mt-3" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingHelpdeskTwo">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseHelpdeskTwo"
                                aria-expanded="false"
                                aria-controls="collapseHelpdeskTwo">
                                <span class="accordion-text">Apa itu SLA dan bagaimana cara kerjanya?</span>
                            </button>
                        </h2>
                        <div id="collapseHelpdeskTwo" class="accordion-collapse collapse"
                        aria-labelledby="headingHelpdeskTwo"
                        data-bs-parent="#faqAccordionHelpdesk">
                            <div class="accordion-body fs-6 px-0 py-1">
                                SLA (Service Level Agreement) adalah standar waktu penyelesaian tiket berdasarkan prioritas: High (4 jam), Medium (24 jam), Low (72 jam). Sistem akan memberikan notifikasi otomatis jika mendekati batas waktu.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item bg-light mt-3" style="border: none;">
                        <h2 class="accordion-header" id="headingHelpdeskThree">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseHelpdeskThree"
                                aria-expanded="false"
                                aria-controls="collapseHelpdeskThree">
                                <span class="accordion-text">Bagaimana cara melacak status tiket saya?</span>
                            </button>
                        </h2>
                        <div id="collapseHelpdeskThree" class="accordion-collapse collapse"
                        aria-labelledby="headingHelpdeskThree"
                        data-bs-parent="#faqAccordionHelpdesk">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Masuk ke menu 'Helpdesk' > 'Tiket Saya', gunakan nomor tiket untuk pencarian cepat, dan lihat timeline progress di detail tiket. Anda juga akan mendapat notifikasi untuk setiap update status.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: Pembatalan Sertifikasi -->
        <div class="card bg-light border border-gray-300 mt-5" data-category="cancel">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border-radius: 25%; background-color: #F57C00;">
                            <i data-lucide="file-x" class="text-white"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Pembatalan Sertifikasi</h3>
                    </div>
                    <span class="badge bg-light fs-7 px-3 py-1 mx-3" style="border: 1px solid rgba(108, 117, 125, 0.4);">
                        2 FAQ
                    </span>
                </div>

                <div class="accordion mt-12" id="faqAccordionCancel">
                <!-- FAQ 1 -->
                    <div class="accordion-item bg-light" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingCancelOne">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelOne"
                                aria-expanded="false"
                                aria-controls="collapseCancelOne">
                                <span class="accordion-text">Bagaimana proses pembatalan sertifikat karena cacat administrasi?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelOne" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelOne"
                        data-bs-parent="#faqAccordionCancel">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Proses: 1) Masuk ke menu 'Pembatalan Sertifikat', 2) Pilih 'Cacat Administrasi', 3) Input nomor sertifikat dan alasan, 4) Upload dokumen pendukung, 5) Sistem generate SK otomatis, 6) Tunggu persetujuan atasan.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item bg-light mt-3" style="border: none;">
                        <h2 class="accordion-header" id="headingCancelTwo">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelTwo"
                                aria-expanded="false"
                                aria-controls="collapseCancelTwo">
                                <span class="accordion-text">Dokumen apa saja yang diperlukan untuk pembatalan sertifikat?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelTwo" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelTwo"
                        data-bs-parent="#faqAccordionCancel">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Dokumen yang diperlukan: 1) Sertifikat asli, 2) Surat permohonan pembatalan, 3) Dokumen pendukung sesuai alasan pembatalan, 4) KTP pemohon, 5) Surat kuasa jika diwakilkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: Sengketa Konflik -->
        <div class="card bg-light border border-gray-300 mt-5" data-category="sengketa">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex justify-content-center align-items-center bg-danger" style="width: 40px; height: 40px; border-radius: 25%;">
                            <i data-lucide="scale" class="text-white"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Sengketa Konflik</h3>
                    </div>
                    <span class="badge bg-light fs-7 px-3 py-1 mx-3" style="border: 1px solid rgba(108, 117, 125, 0.4);">
                        2 FAQ
                    </span>
                </div>

                <div class="accordion mt-12" id="faqAccordionCancelSengketa">
                <!-- FAQ 1 -->
                    <div class="accordion-item bg-light" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingCancelOneSengketa">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelOneSengketa"
                                aria-expanded="false"
                                aria-controls="collapseCancelOneSengketa">
                                <span class="accordion-text">Apa perbedaan antara sengketa dan konflik pertanahan?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelOneSengketa" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelOneSengketa"
                        data-bs-parent="#faqAccordionCancelSengketa">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Sengketa pertanahan adalah perselisihan yang sudah masuk ke ranah hukum/pengadilan, sedangkan konflik pertanahan masih bisa diselesaikan melalui mediasi atau negosiasi.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item bg-light mt-3" style="border: none;">
                        <h2 class="accordion-header" id="headingCancelTwoSengketa">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelTwoSengketa"
                                aria-expanded="false"
                                aria-controls="collapseCancelTwoSengketa">
                                <span class="accordion-text">Bagaimana prosedur penanganan sengketa pertanahan?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelTwoSengketa" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelTwoSengketa"
                        data-bs-parent="#faqAccordionCancelSengketa">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Prosedur: 1) Registrasi kasus, 2) Verifikasi dokumen, 3) Investigasi lapangan, 4) Mediasi (jika memungkinkan), 5) Penyusunan rekomendasi, 6) Tindak lanjut sesuai hasil mediasi/putusan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: Laporan & Statistik -->
        <div class="card bg-light border border-gray-300 mt-5" data-category="laporan">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex justify-content-center align-items-center bg-success" style="width: 40px; height: 40px; border-radius: 25%;">
                            <i data-lucide="chart-column" class="text-white"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Laporan & Statistik</h3>
                    </div>
                    <span class="badge bg-light fs-7 px-3 py-1 mx-3" style="border: 1px solid rgba(108, 117, 125, 0.4);">
                        2 FAQ
                    </span>
                </div>

                <div class="accordion mt-12" id="faqAccordionCancelLaporan">
                <!-- FAQ 1 -->
                    <div class="accordion-item bg-light" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingCancelOneLaporan">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelOneLaporan"
                                aria-expanded="false"
                                aria-controls="collapseCancelOneLaporan">
                                <span class="accordion-text">Bagaimana cara mengakses laporan dan statistik?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelOneLaporan" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelOneLaporan"
                        data-bs-parent="#faqAccordionCancelLaporan">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Akses melalui menu 'Laporan': 1) Pilih jenis laporan, 2) Tentukan rentang tanggal, 3) Filter berdasarkan kategori/wilayah, 4) Generate laporan, 5) Export ke PDF/Excel.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item bg-light mt-3" style="border: none;">
                        <h2 class="accordion-header" id="headingCancelTwoLaporan">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelTwoLaporan"
                                aria-expanded="false"
                                aria-controls="collapseCancelTwoLaporan">
                                <span class="accordion-text">Jenis laporan apa saja yang tersedia?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelTwoLaporan" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelTwoLaporan"
                        data-bs-parent="#faqAccordionCancelLaporan">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Tersedia laporan: 1) Laporan Tiket Helpdesk, 2) Laporan Pembatalan Sertifikat, 3) Laporan Sengketa & Konflik, 4) Laporan Kinerja SLA, 5) Laporan Statistik Regional.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: Manajemen User -->
        <div class="card bg-light border border-gray-300 mt-5" data-category="manajemen">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex justify-content-center align-items-center bg-primary" style="width: 40px; height: 40px; border-radius: 25%;">
                            <i data-lucide="users-round" class="text-white"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Manajemen User</h3>
                    </div>
                    <span class="badge bg-light fs-7 px-3 py-1 mx-3" style="border: 1px solid rgba(108, 117, 125, 0.4);">
                        2 FAQ
                    </span>
                </div>

                <div class="accordion mt-12" id="faqAccordionCancelManajemen">
                <!-- FAQ 1 -->
                    <div class="accordion-item bg-light" style="border: none; border-bottom: 1px solid #dee2e6;">
                        <h2 class="accordion-header" id="headingCancelOneManajemen">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelOneManajemen"
                                aria-expanded="false"
                                aria-controls="collapseCancelOneManajemen">
                                <span class="accordion-text">Bagaimana cara mengelola user dan hak akses?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelOneManajemen" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelOneManajemen"
                        data-bs-parent="#faqAccordionCancelManajemen">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Pengelolaan user (khusus admin): 1) Masuk ke menu 'Pengguna', 2) Tambah user baru, 3) Tentukan role (Admin, Operator, Viewer), 4) Set hak akses per modul, 5) User mendapat email aktivasi.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item bg-light mt-3" style="border: none;">
                        <h2 class="accordion-header" id="headingCancelTwoManajemen">
                            <button class="accordion-button collapsed fw-semibold text-dark bg-light px-0 py-4"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseCancelTwoManajemen"
                                aria-expanded="false"
                                aria-controls="collapseCancelTwoManajemen">
                                <span class="accordion-text">Apa saja role yang tersedia dalam sistem?</span>
                            </button>
                        </h2>
                        <div id="collapseCancelTwoManajemen" class="accordion-collapse collapse"
                        aria-labelledby="headingCancelTwoManajemen"
                        data-bs-parent="#faqAccordionCancelManajemen">
                            <div class="accordion-body fs-6 px-0 py-1">
                                Role tersedia: 1) Super Admin (akses penuh), 2) Admin (kelola user & data), 3) Operator (input & proses data), 4) Viewer (hanya lihat data), 5) Guest (akses terbatas).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/custom-js/help.js') }}"></script>
@endpush
</x-default-layout>
