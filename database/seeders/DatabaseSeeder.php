<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\SimpananPokok;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 15 users, each with Simpanan Pokok and Pinjaman
        User::factory(15)->create()->each(function ($user) {
            SimpananPokok::factory()->create(['id_user' => $user->id_user]);
            Pinjaman::factory()->create(['id_user' => $user->id_user]);
        });
    }
}