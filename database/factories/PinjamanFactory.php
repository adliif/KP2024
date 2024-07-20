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
            // 'id_user' => User::factory(), // Generate a User ID
            // 'besar_pinjaman' => 1000000, // Random besar pinjaman
            // 'tenor_pinjaman' => $this->faker->numberBetween(6, 24), // Random tenor pinjaman (months)
            // 'tgl_pengajuan' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random tgl pengajuan within the last year
            // 'keterangan' => 'Diproses' // Initial status

            'id_user' => User::factory(),
            'tgl_pengajuan' => $this->faker->dateTimeBetween('2023-01-01', '2024-01-31'),
            'tenor_pinjaman' => $this->faker->numberBetween(6, 24), // Random tenor pinjaman (months)
            'besar_pinjaman' => $this->faker->numberBetween(1000000, 10000000),
            'keterangan' => 'Disetujui', // Atau nilai default lainnya
        ];
    }
}
