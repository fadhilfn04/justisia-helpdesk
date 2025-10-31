<x-default-layout>

    @section('title')
        Pembatalan Cacat Administrasi
    @endsection

    {{-- Breadcrumbs bisa ditambah nanti kalau sudah siap --}}
    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('pembatalan.cacat-administrasi') }}
    @endsection --}}

    <div class="d-flex flex-column gap-8">
        
        <!-- Info Banner -->
        <div class="alert alert-info d-flex align-items-center">
            <i class="ki-duotone ki-information-5 fs-2 me-3"></i>
            <div>
                Formulir ini digunakan untuk mengajukan pembatalan sertifikat yang mengandung cacat administrasi
                sesuai Permen ATR/BPN Nomor 21 Tahun 2020.
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-8">

                <!-- Kolom Kiri -->
                <div class="col-lg-7 d-flex flex-column gap-8">

                    <!-- Informasi Sertifikat -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Informasi Sertifikat</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Sertifikat *</label>
                                    <input type="text" class="form-control" placeholder="SRT-123456/2024">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Luas Tanah *</label>
                                    <input type="text" class="form-control" placeholder="500 m²">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Lokasi Tanah *</label>
                                <input type="text" class="form-control" placeholder="Alamat lengkap lokasi tanah">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Nama Pemegang Hak *</label>
                                    <input type="text" class="form-control" placeholder="Nama lengkap pemegang hak">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Alamat Pemegang Hak *</label>
                                    <input type="text" class="form-control" placeholder="Alamat lengkap">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Cacat Administrasi -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Detail Cacat Administrasi</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Jenis Cacat Administrasi *</label>
                                <select class="form-select">
                                    <option value="">Pilih jenis cacat administrasi</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Deskripsi Cacat Administrasi *</label>
                                <textarea class="form-control" rows="3" placeholder="Jelaskan secara detail cacat administrasi yang ditemukan, termasuk bukti dan dampaknya"></textarea>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Koreksi yang Diperlukan *</label>
                                <textarea class="form-control" rows="2" placeholder="Jelaskan koreksi atau perbaikan yang diperlukan"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Dokumen Pendukung</div>
                        </div>
                        <div class="card-body text-center border-dashed py-10">
                            <label for="attachment" class="d-block cursor-pointer">
                                <i class="ki-duotone ki-upload fs-2x mb-3"></i>
                                <div class="fw-semibold mb-2">Drag & drop files atau klik untuk upload</div>
                                <div class="text-gray-500 fs-7">Format: PDF, DOC, JPG, PNG (Max 10MB per file)</div>
                            </label>
                            <input type="file" id="attachment" name="attachment[]" class="d-none" multiple>
                        </div>
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div class="col-lg-5 d-flex flex-column gap-8">

                    <!-- Opsi Tambahan -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Opsi Tambahan</div>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="urgentCheck" name="urgent">
                                <label class="form-check-label fw-semibold" for="urgentCheck">
                                    Kasus mendesak (memerlukan penanganan prioritas)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Estimasi Proses -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Estimasi Proses</div>
                        </div>
                        <div class="card-body text-gray-700">
                            <ul class="mb-0">
                                <li>Review awal: <b>3×24 jam</b></li>
                                <li>Verifikasi lapangan: <b>7–14 hari</b></li>
                                <li>Penerbitan SK: <b>14–21 hari</b></li>
                                <li class="mt-2"><b>Total estimasi:</b> 21–30 hari kerja</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Dasar Hukum -->
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title fw-bold">Dasar Hukum</div>
                        </div>
                        <div class="card-body text-gray-700 fs-7">
                            <ul class="mb-0">
                                <li>Permen ATR/BPN No. 21 Tahun 2020</li>
                                <li>PP No. 18 Tahun 2021</li>
                                <li>UU No. 5 Tahun 1960 (UUPA)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex flex-column gap-3">
                        <button type="submit" class="btn btn-dark w-100 py-3">
                            Ajukan Pembatalan
                        </button>
                        <button type="submit" name="save_draft" value="1" class="btn btn-light w-100 py-3">
                            Simpan Draft
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-default-layout>