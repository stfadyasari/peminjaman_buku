<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return auth()->user()->is_admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('borrower.dashboard');
    }
}
