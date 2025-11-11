<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
        action="{{ route('login') }}">
        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Logo-->
            <div class="mb-5">
                <img alt="Logo" src="{{ image('logos/atrbpn.png') }}" class="h-60px" />
            </div>
            <!--end::Logo-->

            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                Selamat Datang di Helpdesk Justisia
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                Sistem Sengketa, Konflik dan Perkara
            </div>
            <!--end::Subtitle-->
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="Kata Sandi" name="password" autocomplete="off" class="form-control bg-transparent" />
        </div>
        <!--end::Input group-->

        <!--begin::Wrapper-->
        {{-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <a href="{{ route('password.request') }}" class="link-primary">
                Lupa Kata Sandi?
            </a>
        </div> --}}
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => 'Masuk'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        {{-- <div class="text-gray-500 text-center fw-semibold fs-6">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="link-primary">
                Daftar Sekarang
            </a>
        </div> --}}
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

</x-auth-layout>