<?php

namespace Database\Factories;

use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tanggungan>
 */
class TanggunganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pinjaman' => Pinjaman::factory(),
            'total_pinjaman' => '108000',
            'iuran_perBulan' => '108000',
            'sisa_pinjaman' => '1000000',
            'status_pinjaman' => 'Belum Lunas'
        ];
    }
}
