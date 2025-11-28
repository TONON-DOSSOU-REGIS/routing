<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'type' => 'transfer',
            'recipient_name' => $this->faker->name(),
            'recipient_iban' => $this->faker->iban('FR'),
            'recipient_bic' => $this->faker->swiftBicNumber(),
            'bank_name' => $this->faker->company(),
            'reason' => $this->faker->sentence(),
            'activation_code' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
            'progress' => $this->faker->numberBetween(0, 100),
            'message' => $this->faker->optional()->sentence(),
            'meta' => [],
        ];
    }
}

