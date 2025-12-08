<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil semua seeder di sini secara berurutan
        $this->call([
            AdminSeeder::class,   // Membuat akun admin
            KamarSeeder::class,   // Mengisi data kamar
            BerandaSeeder::class, // Mengisi data halaman depan (slider, kontak, map)
        ]);
    }
}