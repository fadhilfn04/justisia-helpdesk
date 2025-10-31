@extends('layout.master')

@section('content')

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1 bg-body">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Page-->
                        {{ $slot }}
                        <!--end::Page-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->

                <!--begin::Footer-->
                {{-- <div class="d-flex flex-center flex-wrap px-5 mt-auto">
                    <div class="d-flex fw-semibold text-gray-500 fs-base">
                        <a href="#" class="px-3 text-hover-primary">Kebijakan Privasi</a>
                        <a href="#" class="px-3 text-hover-primary">Syarat & Ketentuan</a>
                        <a href="#" class="px-3 text-hover-primary">Kontak Kami</a>
                    </div>
                </div> --}}
                <!--end::Footer-->
            </div>
            <!--end::Body-->

            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url({{ image('misc/atrbpn_landing.jpg') }})">
                <!--begin::Content-->
                {{-- <div class="d-flex flex-column flex-center py-10 py-lg-20 px-5 px-md-15 w-100 bg-overlay bg-opacity-50">
                    
                    <!--begin::Logo-->
                    <a href="{{ route('dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ image('logos/atrbpn.png') }}" class="h-200px h-lg-220px"/>
                    </a>
                    <!--end::Logo-->

                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">
                        Justisia
                    </h1>
                    <!--end::Title-->

                    <!--begin::Subtitle-->
                    <div class="d-none d-lg-block text-white fs-base text-center fw-semibold lh-lg">
                        Sistem Informasi <br/>
                        <span class="fw-bold text-warning">Sengketa, Konflik, dan Perkara</span><br/>
                        untuk mendukung penegakan keadilan yang transparan dan akuntabel.
                    </div>
                    <!--end::Subtitle-->
                </div> --}}
                <!--end::Content-->
            </div>
            <!--end::Aside-->

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::App-->

@endsection