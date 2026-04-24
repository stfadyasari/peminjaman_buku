<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(): View
    {
        return view('admin.loans.index', [
            'loans' => Loan::with(['user', 'book'])
                ->where('status', 'dipinjam')
                ->latest('borrowed_at')
                ->get(),
        ]);
    }
}
