<x-default-layout>
<link rel="stylesheet" href="{{ asset('assets/css/custom-css/help.css') }}">

<div class="content-wrapper">
    <div class="container pb-7">
        <div class="mx-auto" style="max-width: 900px;">
            <div class="card border">
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
                <button class="btn btn-dark btn-sm fw-semibold px-3 py-1 filter-btn" data-target="all">
                    Semua Laporan
                </button>
    
                @foreach ($groupedFaqs as $category => $faqs)
                    @php
                        $icon = $icons[$category] ?? 'help-circle';
                    @endphp
                    <button class="btn btn-primary btn-sm fw-semibold px-3 py-1 filter-btn"
                        data-target="{{ Str::slug($category) }}">
                        <i data-lucide="{{ $icon }}" style="width: 1.2rem;"></i> {{ $category }}
                    </button>
                @endforeach
            </div>
    
            @foreach($groupedFaqs as $categoryName => $faqs)
                @php
                    $icon = $icons[$categoryName] ?? 'help-circle';
                @endphp
    
                <div class="card border mt-5" data-category="{{ Str::slug($categoryName) }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px; border-radius: 25%;">
                                    <i data-lucide="{{ $icon }}" class="text-white"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-0">{{ $categoryName }}</h3>
                            </div>
                            <span class="badge fs-7 px-3 py-1 mx-3"
                                style="border: 1px solid rgba(108, 117, 125, 0.4);">
                                {{ $faqs->count() }} FAQ
                            </span>
                        </div>
    
                        <div class="accordion mt-12" id="faqAccordion{{ Str::slug($categoryName) }}">
                            @foreach($faqs as $index => $faq)
                                <div class="accordion-item" style="border: none; border-bottom: 1px solid #dee2e6;">
                                    <h2 class="accordion-header" id="heading{{ Str::slug($categoryName) }}{{ $index }}">
                                        <button class="accordion-button collapsed fw-semibold text-dark px-0 py-4"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ Str::slug($categoryName) }}{{ $index }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ Str::slug($categoryName) }}{{ $index }}">
                                            <span class="accordion-text">{{ $faq->question }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ Str::slug($categoryName) }}{{ $index }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ Str::slug($categoryName) }}{{ $index }}"
                                        data-bs-parent="#faqAccordion{{ Str::slug($categoryName) }}">
                                        <div class="accordion-body fs-6 px-0 py-1">
                                            {!! nl2br(e($faq->answer)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
    
            <div class="card mt-5 border d-none" id="notfoundfaq">
                <div class="card-body py-3 mb-5">
                    <div class="p-10 text-center">
                        <i data-lucide="message-circle" class="mb-3" width="35" height="35"></i>
                        <p class="mb-2 fw-bold fs-2">Tidak ada FAQ yang ditemukan</p>
                        <p class="mb-4 fs-7">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda</p>
                        <label for="fileUpload" class="btn btn-sm border bg-white border-gray-300">
                            Gunakan chatbot untuk bantuan langsung
                        </label>
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
