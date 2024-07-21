<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        // Buat satu pengguna dengan usertype 'admin'
        User::factory()->create([
            'usertype' => 'admin',
        ]);

        // Buat 12 pengguna lainnya sebagai pengguna biasa
        User::factory(12)->create()->each(function ($user) {
            // Buat simpanan pokok untuk setiap user
            SimpananPokok::factory()->create([
                'id_user' => $user->id_user,
            ]);

            // Loop through each month to create a loan
            // $start = Carbon::create(2023, 1, 1);
            // $end = Carbon::create(2024, 1, 31);
            // while ($start->lessThanOrEqualTo($end)) {
            //     Pinjaman::factory()->create([
            //         'id_user' => $user->id_user,
            //         'tgl_pengajuan' => $start->copy()->startOfMonth(),
            //     ]);

            //     $start->addMonth();
            // }
        });
    }
}