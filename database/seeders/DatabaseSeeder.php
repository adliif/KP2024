<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Tanggungan;
use App\Models\SimpananPokok;
use App\Models\TransaksiPokok;
use Illuminate\Database\Seeder;
use App\Models\TransaksiPinjaman;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat satu pengguna dengan usertype 'admin'
        // User::factory()->create([
        //     'usertype' => 'admin',
        // ]);

        // // Buat 12 pengguna lainnya sebagai pengguna biasa
        // User::factory(12)->create()->each(function ($user) {
        //     // Buat simpanan pokok untuk setiap user
        //     SimpananPokok::factory()->create([
        //         'id_user' => $user->id_user,
        //     ]);

        //     // Loop through each month to create a loan
        //     // $start = Carbon::create(2023, 1, 1);
        //     // $end = Carbon::create(2024, 1, 31);
        //     // while ($start->lessThanOrEqualTo($end)) {
        //     //     Pinjaman::factory()->create([
        //     //         'id_user' => $user->id_user,
        //     //         'tgl_pengajuan' => $start->copy()->startOfMonth(),
        //     //     ]);

        //     //     $start->addMonth();
        //     // }
        // });

        // Buat satu pengguna dengan usertype 'admin'
        // User::factory()->create([
        //     'usertype' => 'admin',
        // ]);

        // // Buat 2 pengguna lainnya sebagai anggota
        // $anggota = User::factory(2)->create();

        // $anggota->each(function ($user) {
        //     // Buat simpanan pokok untuk setiap user dengan total simpanan antara 3 juta hingga 5 juta
        //     $simpananPokok = SimpananPokok::factory()->create([
        //         'id_user' => $user->id_user,
        //         'total_simpanan' => rand(3000000, 5000000),
        //         'status_simpanan' => 'Lunas',
        //     ]);

        //     // Buat 3 pinjaman untuk setiap user dengan besar pinjaman antara 1 juta hingga 3 juta
        //     for ($i = 0; $i < 3; $i++) {
        //         $besarPinjaman = rand(1000000, 3000000);
        //         $tgl_pengajuan = Carbon::now()->subMonths(rand(1, 12));
        //         $tenor = 5;
        //         $bunga = 0.8;
        //         $totalPinjaman = $besarPinjaman + ($besarPinjaman * $bunga);
        //         $iuranPerbulan = $totalPinjaman / $tenor;

        //         $pinjaman = Pinjaman::factory()->create([
        //             'id_user' => $user->id_user,
        //             'besar_pinjaman' => $besarPinjaman,
        //             'tgl_pengajuan' => $tgl_pengajuan,
        //             'tenor_pinjaman' => $tenor,
        //             'keterangan' => 'Disetujui',
        //         ]);

        //         // Buat tanggungan untuk setiap pinjaman
        //         $tanggungan = Tanggungan::create([
        //             'id_pinjaman' => $pinjaman->id_pinjaman,
        //             'bunga_pinjaman' => $bunga,
        //             'total_pinjaman' => $totalPinjaman,
        //             'iuran_perbulan' => $iuranPerbulan,
        //             'sisa_pinjaman' => 0,
        //             'sisa_tenor' => 0,
        //             'status_pinjaman' => 'Lunas',
        //             'snap_tokenLunas' => null,
        //         ]);

        //         // Buat transaksi_pinjaman untuk setiap tanggungan
        //         for ($j = 0; $j < $tenor; $j++) {
        //             $tgl_jatuh_tempo = $tgl_pengajuan->copy()->addMonths($j + 1);
        //             $tgl_pembayaran = $tgl_jatuh_tempo->copy()->addDays(rand(1, 30));

        //             TransaksiPinjaman::create([
        //                 'id_tanggungan' => $tanggungan->id_tanggungan,
        //                 'jatuh_tempo' => $tgl_jatuh_tempo,
        //                 'tanggal_pembayaran' => $tgl_pembayaran,
        //                 'snap_token' => null,
        //                 'keterangan' => 'Lunas',
        //             ]);
        //         }
        //     }

        //     // Buat transaksi_pokok untuk simpanan pokok
        //     for ($k = 0; $k < 12; $k++) {
        //         $tgl_jatuh_tempo = Carbon::now()->addMonths($k + 1);
        //         $tgl_pembayaran = $tgl_jatuh_tempo->copy()->addDays(rand(1, 30));

        //         TransaksiPokok::factory()->create([
        //             'id_simpanan_pokok' => $simpananPokok->id_simpanan_pokok,
        //             'jatuh_tempo' => $tgl_jatuh_tempo,
        //             'tanggal_pembayaran' => $tgl_pembayaran,
        //             'snap_token' => null,
        //             'keterangan' => 'Lunas',
        //         ]);
        //     }
        // });

        // Buat 49 pengguna dengan role "user"
        User::factory()->count(49)->create();

        // Buat 1 pengguna dengan role "admin"
        User::factory()->admin()->create([
            'email' => 'admin@example.com', // Anda bisa mengatur email admin sesuai kebutuhan
        ]);
    }
}