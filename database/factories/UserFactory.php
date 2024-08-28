<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;

    public function createUser(string $email): User
    {
        return $this->state(function (array $attributes) use ($email) {
            return
                [
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone_number' => '1234567890',
                    'subscribed_categories' => json_encode([1, 2]),
                    'notification_channels' => json_encode(['email', 'sms']),
                ];
        })->create();
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'subscribed_categories' => json_encode([1, 2]),
            'notification_channels' => json_encode(['email', 'sms']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}