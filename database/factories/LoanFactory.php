<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "amount"         => 100000,
            "duration"       => 24,
            "interestRate"   => 12,
            "arrangementFee" => 2000
        ];
    }
}
