@csrf
<div class="mb-3">
    <label for="question" class="form-label">Pertanyaan</label>
    <input type="text" class="form-control" id="question" name="question" required>
</div>

<div class="mb-3">
    <label for="answer" class="form-label">Jawaban</label>
    <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Kategori</label>
    <select class="form-select" id="category_id" name="category_id" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>