<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalBuku' => Book::count(),
            'stokBuku' => Book::sum('stock'),
            'totalAnggota' => User::where('role', 'peminjam')->count(),
            'totalPengajuan' => Loan::where('status', Loan::STATUS_PENDING_APPROVAL)->count(),
            'totalPeminjaman' => Loan::where('status', Loan::STATUS_BORROWED)->count(),
            'totalVerifikasiKembali' => Loan::where('status', Loan::STATUS_WAITING_RETURN_VERIFICATION)->count(),
            'totalPengembalian' => Loan::where('status', Loan::STATUS_RETURNED)->count(),
            'peminjaman' => Loan::with(['user', 'book'])->latest()->take(6)->get(),
        ]);
    }
}
