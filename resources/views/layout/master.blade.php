<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href="{{ url()->current() }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-css/sidebarHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-css/chatbot.css') }}">

    <!-- FilePond core -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <!-- Plugin preview (gambar) -->
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->
    @livewireStyles
</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

{{-- loader --}}
<div id="loaderTiket" style="display: none !important; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.6); z-index: 9999; display: flex; justify-content: center; align-items: center;">
  <div class="loader-spinner"></div>
</div>


@include('partials/theme-mode/_init')
<div class="mt-8"></div>
@yield('content')

{{-- chatbot --}}

{{-- sembuyikan jika di halaman login --}}
@if (!Request::is('login'))
    <div id="chatButton" class="chat-button">
        <i data-lucide="bot-message-square" width="25" height="25"></i>
    </div>

    <!-- Kotak Chat -->
    <div id="chatBox" class="chat-box shadow">
        <div class="chat-header d-flex justify-content-between align-items-center">
            <span><strong>Chat Bot</strong></span>
            <button class="btn-close btn-sm" id="closeChat"></button>
        </div>

        <div class="chat-body">
            {{-- body isi chatbot --}}
        </div>

        <div class="chat-footer d-flex">
            <input type="text" class="form-control" placeholder="Ketik pesan..." />
            <button class="btn btn-dark ms-2">Kirim</button>
        </div>
    </div>
@endif

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->
@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Custom Javascript-->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="{{ asset('assets/js/custom-js/chatbot.js') }}"></script>

{{-- data lucide icon --}}
<script src="{{ asset('assets/js/lucide/lucide.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();
});
</script>
@stack('scripts')
<!--end::Javascript-->

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = 'Ok, got it!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });
</script>

@livewireScripts
</body>
<!--end::Body-->

</html>
