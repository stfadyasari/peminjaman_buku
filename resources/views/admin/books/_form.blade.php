@php
    $isEdit = isset($book);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.books.update', $book) : route('admin.books.store') }}"
    enctype="multipart/form-data"
    class="mt-6 space-y-5"
>
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <div>
        <label for="code" class="text-sm font-semibold text-slate-700">Kode Buku</label>
        <input id="code" name="code" type="text" value="{{ old('code', $book->code ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
        @error('code')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="title" class="text-sm font-semibold text-slate-700">Judul</label>
        <input id="title" name="title" type="text" value="{{ old('title', $book->title ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
        @error('title')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="author" class="text-sm font-semibold text-slate-700">Penulis</label>
            <input id="author" name="author" type="text" value="{{ old('author', $book->author ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            @error('author')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="publisher" class="text-sm font-semibold text-slate-700">Penerbit</label>
            <input id="publisher" name="publisher" type="text" value="{{ old('publisher', $book->publisher ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            @error('publisher')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="publish_year" class="text-sm font-semibold text-slate-700">Tahun</label>
            <input id="publish_year" name="publish_year" type="number" value="{{ old('publish_year', $book->publish_year ?? '') }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            @error('publish_year')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="stock" class="text-sm font-semibold text-slate-700">Stok</label>
            <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $book->stock ?? 1) }}" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">
            @error('stock')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4" class="mt-2 w-full rounded-2xl border-slate-200/90 bg-white/90 px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="text-sm font-semibold text-slate-700">Image Buku</label>
        <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white/90 px-4 py-3 text-sm text-slate-700 shadow-sm transition duration-200 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-600 hover:file:bg-blue-100 focus:border-blue-500 focus:ring-blue-500">
        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
        @error('image')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($isEdit && $book->hasImage())
        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Image Saat Ini</p>
            <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="mt-3 h-40 w-28 rounded-2xl object-cover shadow-sm ring-1 ring-slate-200">
        </div>
    @endif

    <div class="flex flex-col gap-3 sm:flex-row">
        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_18px_35px_-22px_rgba(37,99,235,0.9)] transition duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:bg-blue-700">
            <i class="fa-solid {{ $isEdit ? 'fa-floppy-disk' : 'fa-plus' }}"></i>
            {{ $isEdit ? 'Update Buku' : 'Simpan Buku' }}
        </button>

        @if ($isEdit)
            <a href="{{ route('admin.books.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white/90 px-4 py-3 text-sm font-semibold text-slate-700 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-50">
                <i class="fa-solid fa-xmark"></i>
                Batal
            </a>
        @endif
    </div>
</form>
