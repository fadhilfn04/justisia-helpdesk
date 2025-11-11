<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
	<!--begin::Heading-->
	<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{ asset('assets/media/misc/menu-header-bg.jpg') }}')">
		<!--begin::Title-->
		<h3 class="text-white fw-semibold px-9 mt-10 mb-6 d-flex align-items-center justify-content-between">
			<span>Notifikasi</span>
			@if (auth()->user()->notifications->where('is_read', false)->count() > 0)
				<span class="fs-8 opacity-75 ps-3">
					{{ auth()->user()->notifications->where('is_read', false)->count() }} belum dibaca
				</span>
			@endif
		</h3>
		<!--end::Title-->
	</div>
	<!--end::Heading-->

	<!--begin::Content-->
	<div class="scroll-y mh-325px my-5 px-8">

		@if (auth()->user()->notifications->where('is_read', false)->count() > 0)
			@foreach (auth()->user()->notifications as $notification)
				<!--begin::Item-->
				<div class="d-flex flex-stack py-4 border-bottom border-gray-200">
					<!--begin::Section-->
					<div class="d-flex align-items-center">
						<!--begin::Symbol-->
						<div class="me-4 position-relative">
							<i data-lucide="message-square-dot" class="me-2 text-primary"></i>
						</div>
						<!--end::Symbol-->

						<!--begin::Title-->
						<div class="mb-0 me-2">
							<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">
								{{ $notification->title }}
							</a>
							<div class="text-gray-500 fs-7">
								{{ $notification->message }}
							</div>
							<div class="text-gray-400 fs-8 mt-1">
								{{ $notification->created_at->diffForHumans() }}
							</div>
						</div>
						<!--end::Title-->
					</div>
					<!--end::Section-->
				</div>
				<!--end::Item-->
			@endforeach
		@else
			<!--begin::Empty state-->
			<div class="text-center py-10">
				<h6 class="text-gray-700 fw-semibold mb-1">Tidak ada notifikasi</h6>
				<p class="text-gray-500 fs-7 mb-0">Semua notifikasi sudah dibaca atau belum ada aktivitas baru.</p>
			</div>
			<!--end::Empty state-->
		@endif

	</div>
	<!--end::Content-->

	<!--begin::Footer-->
	@if (auth()->user()->notifications->where('is_read', false)->count() > 0)
	<div class="py-3 text-center border-top px-8">
		<form action="{{ route('notifications.markAllRead') }}" method="POST" class="d-inline">
			@csrf
			<button type="submit" class="border-0 bg-transparent text-primary fw-semibold text-hover-dark p-0">
				{!! getIcon('check', 'fs-5 me-1') !!} Tandai Semua Dibaca
			</button>
		</form>
	</div>
	@endif
	<!--end::Footer-->
</div>
<!--end::Menu-->