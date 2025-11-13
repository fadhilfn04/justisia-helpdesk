@csrf

<input type="hidden" id="user_id" name="user_id">

<div class="fv-row mb-7">
    <label class="required fw-semibold fs-6 mb-2">Nama Lengkap</label>
    <input type="text" id="name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Lengkap"/>
    @error('name')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="fv-row mb-7">
    <label class="required fw-semibold fs-6 mb-2">Email</label>
    <input type="email" id="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email"/>
    @error('email')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="fv-row mb-7">
    <label class="required fw-semibold fs-6 mb-2">Nomor Telepon</label>
    <input type="string" id="phone" name="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nomor Telepon"/>
    @error('phone')
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-7">
    <label class="required fw-semibold fs-6 mb-5">Role</label>
    @error('role')
    <span class="text-danger">{{ $message }}</span>
    @enderror

    @foreach($roles as $role)
        <div class="d-flex fv-row">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input me-3 role-radio" 
                    id="role_{{ $role->id }}" 
                    name="role_id" 
                    type="radio" 
                    value="{{ $role->id }}"
                    data-role-name="{{ strtolower($role->name) }}" />

                <label class="form-check-label" for="role_{{ $role->id }}">
                    <div class="fw-bold text-gray-800">{{ ucwords($role->name) }}</div>
                    <div class="text-gray-600">{{ $role->description }}</div>
                </label>
            </div>
        </div>

        @if(!$loop->last)
            <div class='separator separator-dashed my-5'></div>
        @endif
    @endforeach
</div>

<!-- Pilihan kategori muncul hanya kalau role Agent -->
<div id="category-container" class="mb-7" style="display: none;">
    <label class="fw-semibold fs-6 mb-2">Pilih Kategori Tiket</label>
    <div class="border rounded p-4 bg-light">
        @foreach($ticketCategories as $category)
            <div class="form-check form-check-custom form-check-solid mb-3">
                <input class="form-check-input me-3" 
                    name="category_ids[]" 
                    type="checkbox" 
                    value="{{ $category->id }}" 
                    id="category_{{ $category->id }}">
                <label class="form-check-label" for="category_{{ $category->id }}">
                    <span class="fw-bold text-gray-800">{{ $category->name }}</span>
                    @if($category->description)
                        <div class="text-gray-600 small">{{ $category->description }}</div>
                    @endif
                </label>
            </div>
        @endforeach
    </div>
</div>