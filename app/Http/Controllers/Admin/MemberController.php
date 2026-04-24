<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        return view('admin.members.index', [
            'members' => User::where('role', 'peminjam')
                ->withCount([
                    'loans as active_loans_count' => fn ($query) => $query->where('status', \App\Models\Loan::STATUS_BORROWED),
                    'loans as returned_loans_count' => fn ($query) => $query->where('status', \App\Models\Loan::STATUS_RETURNED),
                ])
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.members.create');
    }

    public function edit(User $member): View
    {
        abort_unless($member->role === 'peminjam', 404);

        return view('admin.members.edit', [
            'member' => $member,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['role'] = 'peminjam';

        User::create($data);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, User $member): RedirectResponse
    {
        abort_unless($member->role === 'peminjam', 404);

        $data = $this->validatedData($request, $member);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $member->update($data);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $member): RedirectResponse
    {
        abort_unless($member->role === 'peminjam', 404);

        if ($member->loans()->exists()) {
            return back()->with('error', 'Anggota tidak bisa dihapus karena sudah memiliki riwayat peminjaman.');
        }

        $member->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    private function validatedData(Request $request, ?User $member = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($member?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => [$member ? 'nullable' : 'required', 'string', 'min:6'],
        ]);
    }
}
