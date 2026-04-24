<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

#[Fillable(['code', 'title', 'author', 'publisher', 'publish_year', 'stock', 'description', 'image'])]
class Book extends Model
{
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function hasImage(): bool
    {
        return (bool) $this->image && Storage::disk('public')->exists($this->image);
    }

    public function imageUrl(): string
    {
        if (! $this->hasImage()) {
            return "data:image/svg+xml;utf8," . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="160" height="220" viewBox="0 0 160 220">
                    <rect width="160" height="220" rx="24" fill="#e2e8f0"/>
                    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#94a3b8" font-family="Arial, sans-serif" font-size="22" font-weight="700">NO IMG</text>
                </svg>'
            );
        }

        $publicImagePath = public_path('storage/' . str_replace('/', DIRECTORY_SEPARATOR, $this->image));

        if (! File::exists($publicImagePath)) {
            File::ensureDirectoryExists(dirname($publicImagePath));
            File::copy(Storage::disk('public')->path($this->image), $publicImagePath);
        }

        return asset('storage/' . $this->image);
    }
}
