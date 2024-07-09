<?php

namespace Database\Seeders;

use App\Models\Pinjaman;
use App\Models\SimpananPokok;
use App\Models\Tanggungan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        SimpananPokok::factory(10)->recycle([
            User::factory(4)->create(),
            Tanggungan::factory(2)->create(),
            Pinjaman::factory(2)->create()
        ])->create();
    }
}
