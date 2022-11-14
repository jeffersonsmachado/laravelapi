<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(200),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => $this->faker->randomElement(User::all())['id'],
            'date' => $this->faker->dateTimeBetween("-2 years", "now"),
        ];
    }
}
