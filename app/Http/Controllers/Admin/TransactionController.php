<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $returnRequestSortColumn = Schema::hasColumn('loans', 'returned_requested_at')
            ? 'returned_requested_at'
            : 'updated_at';

        return view('admin.transactions.index', [
            'pendingLoans' => Loan::with(['user', 'book'])
                ->where('status', Loan::STATUS_PENDING_APPROVAL)
                ->latest('created_at')
                ->get(),
            'activeLoans' => Loan::with(['user', 'book'])
                ->where('status', Loan::STATUS_BORROWED)
                ->latest('borrowed_at')
                ->get(),
            'returnRequests' => Loan::with(['user', 'book'])
                ->where('status', Loan::STATUS_WAITING_RETURN_VERIFICATION)
                ->latest($returnRequestSortColumn)
                ->get(),
            'completedTransactions' => Loan::with(['user', 'book'])
                ->whereIn('status', [Loan::STATUS_RETURNED, Loan::STATUS_REJECTED])
                ->latest('updated_at')
                ->take(20)
                ->get(),
            'dailyFine' => Loan::DAILY_FINE,
        ]);
    }

    public function approveLoan(Loan $loan): RedirectResponse
    {
        abort_unless($loan->status === Loan::STATUS_PENDING_APPROVAL, 422);

        DB::transaction(function () use ($loan): void {
            $book = $loan->book()->lockForUpdate()->firstOrFail();

            if ($book->stock < 1) {
                abort(422, 'Stok buku habis. Tidak bisa menyetujui peminjaman.');
            }

            $loan->update([
                'status' => Loan::STATUS_BORROWED,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'borrowed_at' => now()->toDateString(),
                'due_at' => now()->addDays(7)->toDateString(),
                'approval_note' => null,
            ]);

            $book->decrement('stock');
        });

        return back()->with('success', 'Peminjaman disetujui. Buku sekarang berstatus dipinjam.');
    }

    public function rejectLoan(Request $request, Loan $loan): RedirectResponse
    {
        abort_unless($loan->status === Loan::STATUS_PENDING_APPROVAL, 422);

        $request->validate([
            'approval_note' => ['nullable', 'string', 'max:255'],
        ]);

        $loan->update([
            'status' => Loan::STATUS_REJECTED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'approval_note' => $request->string('approval_note')->toString() ?: 'Permintaan ditolak oleh admin.',
        ]);

        return back()->with('success', 'Permintaan peminjaman ditolak.');
    }

    public function verifyReturn(Request $request, Loan $loan): RedirectResponse
    {
        abort_unless($loan->status === Loan::STATUS_WAITING_RETURN_VERIFICATION, 422);

        $data = $request->validate([
            'condition_status' => ['required', 'in:baik,rusak_ringan,rusak_berat,hilang'],
            'condition_note' => ['nullable', 'string', 'max:255'],
            'damage_fine' => ['nullable', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($loan, $data): void {
            $book = $loan->book()->lockForUpdate()->firstOrFail();

            $lateDays = max(0, $loan->due_at?->diffInDays(now(), false) ?? 0);
            $lateFine = $lateDays * Loan::DAILY_FINE;
            $damageFine = (int) ($data['damage_fine'] ?? 0);
            $totalFine = $lateFine + $damageFine;

            $loan->update([
                'status' => Loan::STATUS_RETURNED,
                'returned_at' => now()->toDateString(),
                'return_verified_at' => now(),
                'return_verified_by' => auth()->id(),
                'condition_status' => $data['condition_status'],
                'condition_note' => $data['condition_note'] ?? null,
                'late_fine' => $lateFine,
                'damage_fine' => $damageFine,
                'total_fine' => $totalFine,
                'fine_payment_status' => $totalFine > 0 ? Loan::PAYMENT_UNPAID : Loan::PAYMENT_PAID,
                'fine_paid_at' => $totalFine > 0 ? null : now(),
                'fine_payment_method' => $totalFine > 0 ? null : 'qris',
            ]);

            if ($data['condition_status'] !== Loan::CONDITION_LOST) {
                $book->increment('stock');
            }
        });

        return back()->with('success', 'Pengembalian telah diverifikasi dan denda berhasil diperbarui.');
    }
}
