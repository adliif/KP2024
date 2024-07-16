<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SimpananPokok>
 */
class SimpananPokokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::factory(), // Generate a User ID
            'iuran' => 100000, // Fixed iuran for example
            'total_simpanan' => 0, // Null for initial state
            'status_simpanan' => 'Lunas' // Initial status
        ];
    }
}
