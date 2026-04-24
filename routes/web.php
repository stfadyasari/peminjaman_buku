<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Borrower\DashboardController as BorrowerDashboardController;
use App\Http\Controllers\Borrower\LoanController as BorrowerLoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/books/{book}/cover', [AdminBookController::class, 'cover'])->name('books.cover');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [AdminBookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [AdminBookController::class, 'create'])->name('books.create');
    Route::post('/books', [AdminBookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}', [AdminBookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit', [AdminBookController::class, 'edit'])->name('books.edit');
    Route::patch('/books/{book}', [AdminBookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])->name('books.destroy');
    Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [AdminMemberController::class, 'create'])->name('members.create');
    Route::post('/members', [AdminMemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('members.edit');
    Route::patch('/members/{member}', [AdminMemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [AdminMemberController::class, 'destroy'])->name('members.destroy');
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{loan}/approve', [AdminTransactionController::class, 'approveLoan'])->name('transactions.approve');
    Route::patch('/transactions/{loan}/reject', [AdminTransactionController::class, 'rejectLoan'])->name('transactions.reject');
    Route::patch('/transactions/{loan}/verify-return', [AdminTransactionController::class, 'verifyReturn'])->name('transactions.verify-return');
    Route::get('/loans', fn () => redirect()->route('admin.transactions.index'))->name('loans.index');
    Route::get('/returns', fn () => redirect()->route('admin.transactions.index'))->name('returns.index');
    Route::get('/fines', fn () => redirect()->route('admin.transactions.index'))->name('fines.index');
    Route::get('/logs', [AdminActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/print', [AdminActivityLogController::class, 'print'])->name('logs.print');
    Route::get('/logs/pdf', [AdminActivityLogController::class, 'downloadPdf'])->name('logs.pdf');
});

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('borrower.')->group(function () {
    Route::get('/dashboard', [BorrowerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/ajukan-peminjaman', [BorrowerDashboardController::class, 'submission'])->name('submission');
    Route::get('/peminjaman', [BorrowerDashboardController::class, 'loans'])->name('loans');
    Route::get('/riwayat-peminjaman', [BorrowerDashboardController::class, 'loanHistory'])->name('loan-history');
    Route::post('/loans', [BorrowerLoanController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{loan}/return', [BorrowerLoanController::class, 'returnBook'])->name('loans.return');
    Route::patch('/loans/{loan}/pay-qris', [BorrowerLoanController::class, 'payFineWithQris'])->name('loans.pay-qris');
});

require __DIR__.'/auth.php';
