<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('borrower.dashboard', [
            'activeLoans' => Loan::with('book')
                ->whereBelongsTo($user)
                ->whereIn('status', [
                    Loan::STATUS_PENDING_APPROVAL,
                    Loan::STATUS_BORROWED,
                    Loan::STATUS_WAITING_RETURN_VERIFICATION,
                ])
                ->latest('updated_at')
                ->get(),
            'availableBooks' => Book::query()->where('stock', '>', 0)->count(),
            'pendingApprovalCount' => Loan::whereBelongsTo($user)->where('status', Loan::STATUS_PENDING_APPROVAL)->count(),
            'borrowedCount' => Loan::whereBelongsTo($user)
                ->whereIn('status', [Loan::STATUS_BORROWED, Loan::STATUS_WAITING_RETURN_VERIFICATION])
                ->count(),
            'returnedCount' => Loan::whereBelongsTo($user)->where('status', Loan::STATUS_RETURNED)->count(),
            'outstandingFineCount' => Loan::whereBelongsTo($user)
                ->where('status', Loan::STATUS_RETURNED)
                ->where('total_fine', '>', 0)
                ->where('fine_payment_status', '!=', Loan::PAYMENT_PAID)
                ->count(),
            'outstandingFineAmount' => (int) Loan::whereBelongsTo($user)
                ->where('status', Loan::STATUS_RETURNED)
                ->where('total_fine', '>', 0)
                ->where('fine_payment_status', '!=', Loan::PAYMENT_PAID)
                ->sum('total_fine'),
        ]);
    }

    public function submission(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $user = auth()->user();

        $booksQuery = Book::query()
            ->where('stock', '>', 0)
            ->orderByDesc('stock')
            ->orderBy('title');

        if ($search !== '') {
            $booksQuery->where(function ($query) use ($search): void {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('publisher', 'like', '%' . $search . '%');
            });
        }

        return view('borrower.submission', [
            'books' => $booksQuery->get(),
            'search' => $search,
            'availableBooks' => Book::query()->where('stock', '>', 0)->count(),
            'pendingApprovalCount' => Loan::whereBelongsTo($user)->where('status', Loan::STATUS_PENDING_APPROVAL)->count(),
        ]);
    }

    public function loans(): View
    {
        $loans = Loan::with('book')
            ->whereBelongsTo(auth()->user())
            ->latest()
            ->get();

        $loanEntries = $this->buildLoanEntries($loans);

        return view('borrower.loans', [
            'loanEntries' => $loanEntries,
            'pendingCount' => $loans->where('status', Loan::STATUS_PENDING_APPROVAL)->count(),
            'activeCount' => $loans->whereIn('status', [Loan::STATUS_BORROWED, Loan::STATUS_WAITING_RETURN_VERIFICATION])->count(),
            'returnedCount' => $loans->where('status', Loan::STATUS_RETURNED)->count(),
            'unpaidCount' => $loanEntries->where('payment_status', 'Belum Dibayar')->count(),
            'outstandingFineAmount' => $loanEntries
                ->where('payment_status', 'Belum Dibayar')
                ->sum('fine_amount'),
        ]);
    }

    public function loanHistory(): View
    {
        $historyLoans = Loan::with('book')
            ->whereBelongsTo(auth()->user())
            ->whereIn('status', [Loan::STATUS_RETURNED, Loan::STATUS_REJECTED])
            ->latest()
            ->get();

        $historyEntries = $this->buildLoanEntries($historyLoans);

        return view('borrower.loan-history', [
            'historyEntries' => $historyEntries,
            'returnedCount' => $historyLoans->where('status', Loan::STATUS_RETURNED)->count(),
            'rejectedCount' => $historyLoans->where('status', Loan::STATUS_REJECTED)->count(),
            'paidCount' => $historyEntries->where('payment_status', 'Lunas')->count(),
            'unpaidCount' => $historyEntries->where('payment_status', 'Belum Dibayar')->count(),
        ]);
    }

    private function buildLoanEntries(Collection $loans): Collection
    {
        return $loans
            ->map(function (Loan $loan) {
                $fineAmount = (int) ($loan->total_fine ?? 0);
                $isPaid = $loan->fine_payment_status === Loan::PAYMENT_PAID;

                return (object) [
                    'loan' => $loan,
                    'late_days' => (int) floor(($loan->late_fine ?? 0) / Loan::DAILY_FINE),
                    'fine_amount' => $fineAmount,
                    'damage_fine' => (int) ($loan->damage_fine ?? 0),
                    'late_fine' => (int) ($loan->late_fine ?? 0),
                    'payment_status' => $fineAmount < 1
                        ? 'Tidak Ada Denda'
                        : ($isPaid ? 'Lunas' : 'Belum Dibayar'),
                ];
            })
            ->values();
    }
}
