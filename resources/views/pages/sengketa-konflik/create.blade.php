<x-default-layout>

    @section('title')
        Buat Tiket Baru
    @endsection

    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('helpdesk.create') }}
    @endsection --}}

    <div class="card">
        <div class="card-body py-5 px-10">
            <div class="d-flex flex-column gap-7">

                <!-- Header -->
                <div class="alert alert-info d-flex align-items-center">
                    <i class="ki-duotone ki-information-5 fs-2 me-3"></i>
                    <div>
                        Pastikan semua informasi yang Anda berikan akurat dan lengkap untuk mempercepat proses penanganan.
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-7">

                        <!-- Informasi Tiket -->
                        <div class="col-lg-7">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">
                                        Informasi Tiket
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Judul Tiket</label>
                                        <input type="text" name="title" class="form-control" placeholder="Ringkasan singkat masalah Anda" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Deskripsi Detail</label>
                                        <textarea name="description" rows="4" class="form-control" placeholder="Jelaskan masalah Anda secara detail..." required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="category_id" class="form-select" required>
                                                <option value="">Pilih kategori masalah</option>
                                                {{-- @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="form-label fw-bold">Wilayah</label>
                                            <select name="region" class="form-select">
                                                <option value="">Pilih wilayah</option>
                                                <option>DKI Jakarta</option>
                                                <option>Jawa Barat</option>
                                                <option>Jawa Tengah</option>
                                                <option>Jawa Timur</option>
                                                <option>Sumatera Utara</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label class="form-label fw-bold">Prioritas</label>
                                            <select name="priority" class="form-select" required>
                                                <option value="">Pilih prioritas</option>
                                                <option value="tinggi">Tinggi</option>
                                                <option value="sedang">Sedang</option>
                                                <option value="rendah">Rendah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar kanan -->
                        <div class="col-lg-5 d-flex flex-column gap-7">
                            <!-- Opsi Tambahan -->
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">
                                        Opsi Tambahan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="urgent" id="urgentCheck">
                                        <label class="form-check-label fw-semibold" for="urgentCheck">
                                            Kasus mendesak (memerlukan penanganan segera)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Estimasi SLA -->
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">
                                        Estimasi SLA
                                    </div>
                                </div>
                                <div class="card-body text-gray-700">
                                    <p class="mb-1">Berdasarkan kategori dan prioritas:</p>
                                    <ul class="mb-0">
                                        <li>Respon awal: <b>3×24 jam</b></li>
                                        <li>Penyelesaian: <b>7–14 hari kerja</b></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <!-- Data Pelapor -->
                        <div class="col-lg-7">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">
                                        Data Pelapor
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" name="reporter_name" class="form-control" value="{{ auth()->user()->name ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" name="reporter_email" class="form-control" value="{{ auth()->user()->email ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nomor Telepon</label>
                                        <input type="text" name="reporter_phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lampiran Dokumen -->
                        <div class="col-lg-7">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">
                                        Lampiran Dokumen
                                    </div>
                                </div>
                                <div class="card-body text-center border-dashed py-5">
                                    <label for="attachment" class="d-block cursor-pointer">
                                        <i class="ki-duotone ki-upload fs-2x mb-2"></i>
                                        <div class="fw-semibold mb-2">Drag & drop files atau klik untuk upload</div>
                                        <div class="text-gray-500 fs-7">(maksimal 10MB per file)</div>
                                    </label>
                                    <input type="file" id="attachment" name="attachment[]" class="d-none" multiple>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol -->
                        <div class="col-lg-12 d-flex justify-content-end gap-3">
                            <button type="submit" name="save_draft" value="1" class="btn btn-light">
                                Simpan Draft
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Buat Tiket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-default-layout>