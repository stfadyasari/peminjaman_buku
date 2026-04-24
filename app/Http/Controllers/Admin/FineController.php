<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(): View
    {
        $dailyFine = Loan::DAILY_FINE;

        $fines = Loan::with(['user', 'book'])
            ->get()
            ->map(function (Loan $loan) use ($dailyFine) {
                $lateDays = $loan->lateDays();
                $fineAmount = $loan->fineAmount($dailyFine);

                return (object) [
                    'loan' => $loan,
                    'late_days' => $lateDays,
                    'fine_amount' => $fineAmount,
                ];
            })
            ->filter(fn (object $fine) => $fine->fine_amount > 0)
            ->sortByDesc(fn (object $fine) => $fine->fine_amount)
            ->values();

        return view('admin.fines.index', [
            'fines' => $fines,
            'dailyFine' => $dailyFine,
            'totalFineAmount' => $fines->sum('fine_amount'),
        ]);
    }
}
