<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pinjaman>
 */
class PinjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::Factory(),
            'tgl_pengajuan' => '2024-07-08 14:30:30',
            'besar_pinjaman' => '100000',
            'tenor_pinjaman' => '3',
            'keterangan' => 'Diproses',
        ];
    }
}
