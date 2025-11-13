<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'id_type' => fake()->randomElement(['CNI', 'Passport', 'Permis']),
            'id_number' => fake()->numerify('##########'),
            'iban' => fake()->iban('FR'),
            'bic' => fake()->swiftBicNumber(),
            'role' => 'user',
            'balance' => fake()->randomFloat(2, 0, 10000),
            'status' => 'active',
            'password' => static::$password ??= Hash::make('password'),
            'activation_code' => fake()->optional()->word(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
