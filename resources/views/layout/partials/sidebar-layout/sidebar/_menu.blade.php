<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
			<div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
					<i data-lucide="layout-dashboard" class="menu-icon" width="18" height="18"></i>
					<span class="menu-title">Dashboard</span>
				</a>
				<!--end:Menu link-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
            <div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link {{ request()->routeIs('tiket.index') ? 'active' : '' }}" href="{{ route('tiket.index') }}">
					<i data-lucide="ticket" class="menu-icon" width="18" height="18"></i>
					<span class="menu-title">Helpdesk</span>
				</a>
				<!--end:Menu link-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
            @if (auth()->user()->role->id != '3' && auth()->user()->role->id != '2')
                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                        <i data-lucide="chart-column" class="menu-icon" width="18" height="18"></i>
                        <span class="menu-title">Laporan</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <i data-lucide="users" class="menu-icon" width="18" height="18"></i>
                        <span class="menu-title">Manajemen Pengguna</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengguna</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        {{-- <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Role</span>
                            </a>
                            <!--end:Menu link-->
                        </div> --}}
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        {{-- <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Izin Akses</span>
                            </a>
                            <!--end:Menu link-->
                        </div> --}}
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
            @endif
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('help.*') ? 'here show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<i data-lucide="message-circle" class="menu-icon" width="18" height="18"></i>
					<span class="menu-title">Bantuan & FAQ</span>
					<span class="menu-arrow"></span>
				</span>
				<!--end:Menu link-->
				<!--begin:Menu sub-->
				<div class="menu-sub menu-sub-accordion">
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('help.index') ? 'active' : '' }}" href="{{ route('help.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">FAQ</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('help.guide') ? 'active' : '' }}" href="{{ route('help.guide') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Panduan Pengguna</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('help.kontak') ? 'active' : '' }}" href="{{ route('help.kontak') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Kontak Support</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					{{-- <div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Role</span>
						</a>
						<!--end:Menu link-->
					</div> --}}
					<!--end:Menu item-->
					<!--begin:Menu item-->
					{{-- <div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Izin Akses</span>
						</a>
						<!--end:Menu link-->
					</div> --}}
					<!--end:Menu item-->
				</div>
				<!--end:Menu sub-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
			{{-- <div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
					<span class="menu-icon">{!! getIcon('rocket', 'fs-2') !!}</span>
					<span class="menu-title">Pengaturan</span>
				</a>
				<!--end:Menu link-->
			</div> --}}
			<!--end:Menu item-->
			<!--begin:Menu item-->
			{{-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('tiket.*') ? 'here show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
					<span class="menu-title">Bantuan & FAQ</span>
					<span class="menu-arrow"></span>
				</span>
				<!--end:Menu link-->
				<!--begin:Menu sub-->
				<div class="menu-sub menu-sub-accordion">
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('tiket.index') ? 'active' : '' }}" href="{{ route('tiket.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">FAQ</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('tiket.index') ? 'active' : '' }}" href="{{ route('tiket.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Panduan Pengguna</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('tiket.create') ? 'active' : '' }}" href="{{ route('tiket.create') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Kontak Support</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
				</div>
				<!--end:Menu sub-->
			</div> --}}
			<!--end:Menu item-->
		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
