<!--begin::Chat drawer-->
<div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
	<!--begin::Messenger-->
	<div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
		<!--begin::Card header-->
		<div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
			<!--begin::Title-->
			<div class="card-title">
				<!--begin::User-->
				<div class="d-flex justify-content-center flex-column me-3">
					<a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Brian Cox</a>
					<!--begin::Info-->
					<div class="mb-0 lh-1">
						<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
						<span class="fs-7 fw-semibold text-muted">Active</span>
					</div>
					<!--end::Info-->
				</div>
				<!--end::User-->
			</div>
			<!--end::Title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Close-->
				<div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">{!! getIcon('cross-square', 'fs-2') !!}</div>
				<!--end::Close-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body" id="kt_drawer_chat_messenger_body">
			<!--begin::Messages-->
			<div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
				<!--begin::Message(in)-->
				<div class="d-flex justify-content-start mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-start">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-25.jpg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Details-->
							<div class="ms-3">
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
								<span class="text-muted fs-7 mb-1">2 mins</span>
							</div>
							<!--end::Details-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(in)-->
				<!--begin::Message(out)-->
				<div class="d-flex justify-content-end mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-end">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Details-->
							<div class="me-3">
								<span class="text-muted fs-7 mb-1">5 mins</span>
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
							</div>
							<!--end::Details-->
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-1.jpg') }}" />
							</div>
							<!--end::Avatar-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(out)-->
				<!--begin::Message(in)-->
				<div class="d-flex justify-content-start mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-start">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-25.jpg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Details-->
							<div class="ms-3">
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
								<span class="text-muted fs-7 mb-1">1 Hour</span>
							</div>
							<!--end::Details-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Ok, Understood!</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(in)-->
				<!--begin::Message(out)-->
				<div class="d-flex justify-content-end mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-end">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Details-->
							<div class="me-3">
								<span class="text-muted fs-7 mb-1">2 Hours</span>
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
							</div>
							<!--end::Details-->
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-1.jpg') }}" />
							</div>
							<!--end::Avatar-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">You’ll receive notifications for all issues, pull requests!</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(out)-->
				<!--begin::Message(in)-->
				<div class="d-flex justify-content-start mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-start">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-25.jpg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Details-->
							<div class="ms-3">
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
								<span class="text-muted fs-7 mb-1">3 Hours</span>
							</div>
							<!--end::Details-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">You can unwatch this repository immediately by clicking here: 
						<a href="https://keenthemes.com">Keenthemes.com</a></div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(in)-->
				<!--begin::Message(out)-->
				<div class="d-flex justify-content-end mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-end">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Details-->
							<div class="me-3">
								<span class="text-muted fs-7 mb-1">4 Hours</span>
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
							</div>
							<!--end::Details-->
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-1.jpg') }}" />
							</div>
							<!--end::Avatar-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Most purchased Business courses during this sale!</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(out)-->
				<!--begin::Message(in)-->
				<div class="d-flex justify-content-start mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-start">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-25.jpg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Details-->
							<div class="ms-3">
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
								<span class="text-muted fs-7 mb-1">5 Hours</span>
							</div>
							<!--end::Details-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(in)-->
				<!--begin::Message(template for out)-->
				<div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-end">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Details-->
							<div class="me-3">
								<span class="text-muted fs-7 mb-1">Just now</span>
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
							</div>
							<!--end::Details-->
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-1.jpg') }}" />
							</div>
							<!--end::Avatar-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text"></div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(template for out)-->
				<!--begin::Message(template for in)-->
				<div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column align-items-start">
						<!--begin::User-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Avatar-->
							<div class="symbol symbol-35px symbol-circle">
								<img alt="Pic" src="{{ image('avatars/300-25.jpg') }}" />
							</div>
							<!--end::Avatar-->
							<!--begin::Details-->
							<div class="ms-3">
								<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
								<span class="text-muted fs-7 mb-1">Just now</span>
							</div>
							<!--end::Details-->
						</div>
						<!--end::User-->
						<!--begin::Text-->
						<div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Right before vacation season we have the next Big Deal for you.</div>
						<!--end::Text-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Message(template for in)-->
			</div>
			<!--end::Messages-->
		</div>
		<!--end::Card body-->
		<!--begin::Card footer-->
		<div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
			<!--begin::Input-->
			<textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
			<!--end::Input-->
			<!--begin:Toolbar-->
			<div class="d-flex flex-stack">
				<!--begin::Actions-->
				<div class="d-flex align-items-center me-2">
					<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">{!! getIcon('paper-clip', 'fs-3') !!}</button>
					<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">{!! getIcon('cloud-add', 'fs-3') !!}</button>
				</div>
				<!--end::Actions-->
				<!--begin::Send-->
				<button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
				<!--end::Send-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Messenger-->
</div>
<!--end::Chat drawer-->
