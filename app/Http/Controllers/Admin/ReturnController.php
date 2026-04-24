<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function index(): View
    {
        return view('admin.returns.index', [
            'returns' => Loan::with(['user', 'book'])
                ->where('status', 'dikembalikan')
                ->latest('returned_at')
                ->get(),
        ]);
    }
}
