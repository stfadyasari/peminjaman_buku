<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $user = $request->user();
        $book = Book::findOrFail($data['book_id']);

        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku sedang habis.');
        }

        $hasActiveLoan = Loan::whereBelongsTo($user)
            ->where('book_id', $book->id)
            ->whereIn('status', [
                Loan::STATUS_PENDING_APPROVAL,
                Loan::STATUS_BORROWED,
                Loan::STATUS_WAITING_RETURN_VERIFICATION,
            ])
            ->exists();

        if ($hasActiveLoan) {
            return back()->with('error', 'Anda masih memiliki proses pinjam aktif untuk buku ini.');
        }

        DB::transaction(function () use ($user, $book): void {
            Loan::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'requested_at' => now()->toDateString(),
                'borrowed_at' => now()->toDateString(),
                'due_at' => now()->addDays(7)->toDateString(),
                'status' => Loan::STATUS_PENDING_APPROVAL,
            ]);
        });

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function returnBook(Loan $loan): RedirectResponse
    {
        abort_unless($loan->user_id === auth()->id() && $loan->status === Loan::STATUS_BORROWED, 403);

        DB::transaction(function () use ($loan): void {
            $loan->update([
                'returned_requested_at' => now()->toDateString(),
                'status' => Loan::STATUS_WAITING_RETURN_VERIFICATION,
                'approval_note' => null,
            ]);
        });

        return back()->with('success', 'Permintaan pengembalian dikirim. Menunggu verifikasi admin.');
    }

    public function payFineWithQris(Loan $loan): RedirectResponse
    {
        abort_unless($loan->user_id === auth()->id(), 403);
        abort_unless($loan->status === Loan::STATUS_RETURNED && $loan->total_fine > 0, 422);

        if ($loan->fine_payment_status === Loan::PAYMENT_PAID) {
            return back()->with('success', 'Tagihan sudah dinyatakan lunas.');
        }

        $loan->update([
            'fine_payment_status' => Loan::PAYMENT_PAID,
            'fine_payment_method' => 'qris',
            'fine_paid_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran QRIS berhasil dicatat. Tagihan Anda sudah lunas.');
    }
}
