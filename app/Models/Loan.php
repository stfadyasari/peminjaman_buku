<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable([
    'user_id',
    'book_id',
    'requested_at',
    'borrowed_at',
    'due_at',
    'returned_requested_at',
    'returned_at',
    'status',
    'approved_at',
    'approved_by',
    'return_verified_at',
    'return_verified_by',
    'condition_status',
    'condition_note',
    'late_fine',
    'damage_fine',
    'total_fine',
    'fine_payment_status',
    'fine_payment_method',
    'fine_paid_at',
    'approval_note',
])]
class Loan extends Model
{
    public const DAILY_FINE = 5000;
    public const STATUS_PENDING_APPROVAL = 'menunggu_persetujuan';
    public const STATUS_REJECTED = 'ditolak';
    public const STATUS_BORROWED = 'dipinjam';
    public const STATUS_WAITING_RETURN_VERIFICATION = 'menunggu_verifikasi_pengembalian';
    public const STATUS_RETURNED = 'dikembalikan';

    public const PAYMENT_UNPAID = 'belum_bayar';
    public const PAYMENT_PAID = 'lunas';

    public const CONDITION_GOOD = 'baik';
    public const CONDITION_LIGHT_DAMAGE = 'rusak_ringan';
    public const CONDITION_HEAVY_DAMAGE = 'rusak_berat';
    public const CONDITION_LOST = 'hilang';

    protected function casts(): array
    {
        return [
            'requested_at' => 'date',
            'borrowed_at' => 'date',
            'due_at' => 'date',
            'returned_requested_at' => 'date',
            'returned_at' => 'date',
            'approved_at' => 'datetime',
            'return_verified_at' => 'datetime',
            'fine_paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnVerifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'return_verified_by');
    }

    public function lateDays(): int
    {
        if (! $this->due_at) {
            return 0;
        }

        $endDate = $this->returned_at ? Carbon::parse($this->returned_at) : now();

        return max(0, Carbon::parse($this->due_at)->diffInDays($endDate, false));
    }

    public function fineAmount(int $dailyFine = self::DAILY_FINE): int
    {
        return $this->lateDays() * $dailyFine;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING_APPROVAL => 'Menunggu Persetujuan',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_BORROWED => 'Dipinjam',
            self::STATUS_WAITING_RETURN_VERIFICATION => 'Menunggu Verifikasi Pengembalian',
            self::STATUS_RETURNED => 'Dikembalikan',
            default => ucfirst((string) $this->status),
        };
    }

    public function conditionLabel(): string
    {
        return match ($this->condition_status) {
            self::CONDITION_GOOD => 'Baik',
            self::CONDITION_LIGHT_DAMAGE => 'Rusak Ringan',
            self::CONDITION_HEAVY_DAMAGE => 'Rusak Berat',
            self::CONDITION_LOST => 'Hilang',
            default => '-',
        };
    }
}
