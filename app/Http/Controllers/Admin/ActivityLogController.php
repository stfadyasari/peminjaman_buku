<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $activities = $this->activities();

        return view('admin.logs.index', [
            'activities' => $activities,
        ]);
    }

    public function print(): View
    {
        return view('admin.logs.print', [
            'activities' => $this->activities(),
            'generatedAt' => now(),
        ]);
    }

    public function downloadPdf(): Response
    {
        $filename = 'laporan-log-aktivitas-' . Str::of(now()->format('Y-m-d-H-i-s'))->replace(':', '-') . '.pdf';

        $pdf = Pdf::loadView('admin.logs.pdf', [
            'activities' => $this->activities(),
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    private function activities(): Collection
    {
        return Loan::with(['user', 'book'])
            ->latest()
            ->get()
            ->flatMap(function (Loan $loan): Collection {
                $logs = collect([
                    (object) [
                        'action' => 'Permintaan peminjaman',
                        'description' => ($loan->user->name ?? 'Anggota') . ' mengajukan pinjam buku ' . ($loan->book->title ?? '-'),
                        'date' => $loan->requested_at ?? $loan->created_at,
                        'status' => Loan::STATUS_PENDING_APPROVAL,
                    ],
                ]);

                if ($loan->approved_at && $loan->status !== Loan::STATUS_REJECTED) {
                    $logs->push((object) [
                        'action' => 'Peminjaman disetujui',
                        'description' => 'Admin menyetujui peminjaman untuk ' . ($loan->user->name ?? 'Anggota'),
                        'date' => $loan->approved_at,
                        'status' => Loan::STATUS_BORROWED,
                    ]);
                }

                if ($loan->status === Loan::STATUS_REJECTED) {
                    $logs->push((object) [
                        'action' => 'Permintaan ditolak',
                        'description' => 'Permintaan pinjam untuk ' . ($loan->user->name ?? 'Anggota') . ' ditolak.',
                        'date' => $loan->approved_at ?? $loan->updated_at,
                        'status' => Loan::STATUS_REJECTED,
                    ]);
                }

                if ($loan->returned_requested_at) {
                    $logs->push((object) [
                        'action' => 'Permintaan pengembalian',
                        'description' => ($loan->user->name ?? 'Anggota') . ' mengirim permintaan verifikasi pengembalian.',
                        'date' => $loan->returned_requested_at,
                        'status' => Loan::STATUS_WAITING_RETURN_VERIFICATION,
                    ]);
                }

                if ($loan->returned_at) {
                    $logs->push((object) [
                        'action' => 'Pengembalian diverifikasi',
                        'description' => ($loan->user->name ?? 'Anggota') . ' selesai pengembalian buku ' . ($loan->book->title ?? '-'),
                        'date' => $loan->returned_at,
                        'status' => Loan::STATUS_RETURNED,
                    ]);
                }

                return $logs;
            })
            ->sortByDesc('date')
            ->values();
    }
}
