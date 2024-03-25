<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user1 = User::inRandomOrder()->first()->id;

        return [
            'user_1' => $user1,
            'user_2' => User::where('id', '!=', $user1)->inRandomOrder()->first()->id,
        ];
    }
}
