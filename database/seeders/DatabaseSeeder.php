<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin Perpustakaan',
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Perpustakaan',
            'password' => Hash::make('password'),
        ]);

        User::updateOrCreate([
            'email' => 'anggota@perpustakaan.test',
        ], [
            'name' => 'Anggota Demo',
            'role' => 'peminjam',
            'phone' => '081298765432',
            'address' => 'Jl. Melati No. 10',
            'password' => Hash::make('password'),
        ]);

        foreach ([
            [
                'code' => 'BK-001',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'publish_year' => 2005,
                'stock' => 5,
                'description' => 'Novel populer Indonesia yang cocok untuk koleksi perpustakaan sekolah.',
            ],
            [
                'code' => 'BK-002',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'publish_year' => 1980,
                'stock' => 3,
                'description' => 'Karya sastra Indonesia yang sering dipinjam anggota.',
            ],
            [
                'code' => 'BK-003',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Avery',
                'publish_year' => 2018,
                'stock' => 4,
                'description' => 'Buku pengembangan diri untuk koleksi bacaan populer.',
            ],
        ] as $book) {
            Book::updateOrCreate([
                'code' => $book['code'],
            ], $book);
        }
    }
}
