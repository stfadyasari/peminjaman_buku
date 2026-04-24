<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        return view('admin.books.index', [
            'books' => Book::withCount([
                'loans as borrowed_count' => fn ($query) => $query->where('status', 'dipinjam'),
            ])->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.books.create');
    }

    public function cover(Book $book): Response
    {
        abort_unless($book->image && Storage::disk('public')->exists($book->image), 404);

        return Storage::disk('public')->response($book->image);
    }

    public function show(Book $book): View
    {
        $book->loadCount([
            'loans',
            'loans as borrowed_count' => fn ($query) => $query->where('status', 'dipinjam'),
        ])->load([
            'loans' => fn ($query) => $query->with('user')->latest()->limit(5),
        ]);

        return view('admin.books.show', [
            'book' => $book,
        ]);
    }

    public function edit(Book $book): View
    {
        return view('admin.books.edit', [
            'book' => $book,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data = $this->storeUploadedImage($request, $data);

        Book::create($data);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $this->validatedData($request, $book);
        $oldImage = $book->image;
        $data = $this->storeUploadedImage($request, $data, $oldImage);

        $book->update($data);

        if ($request->hasFile('image') && $oldImage && $oldImage !== $book->image) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->loans()->exists()) {
            return back()->with('error', 'Buku tidak bisa dihapus karena sudah memiliki riwayat peminjaman.');
        }

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Book $book = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('books', 'code')->ignore($book?->id)],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publish_year' => ['nullable', 'integer', 'digits:4'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function storeUploadedImage(Request $request, array $data, ?string $oldImage = null): array
    {
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        } elseif ($oldImage) {
            $data['image'] = $oldImage;
        }

        if (! Schema::hasColumn('books', 'image')) {
            if (! empty($data['image']) && $data['image'] !== $oldImage) {
                Storage::disk('public')->delete($data['image']);
            }

            unset($data['image']);
        }

        return $data;
    }
}
