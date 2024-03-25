<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chat = Chat::inRandomOrder()->first();

        return [
            'from' => $this->faker->randomElement([$chat->user_1, $chat->user_2]),
            'value' => $this->faker->sentence(),
            'chat_id' => $chat->id,
        ];
    }
}
