<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            // Keep only the identity fields still required by the current schema.
            'iban' => $this->faker->iban('FR'),
            'bic' => $this->faker->swiftBicNumber(),
            'role' => 'user',
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'status' => 'active',
            'password' => static::$password ??= Hash::make('password'),
            'activation_code' => $this->faker->optional()->word(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'id_type' => 'Passport',
            'id_number' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
