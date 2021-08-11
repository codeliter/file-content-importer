<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'checked' => $this->faker->boolean,
            'description' => $this->faker->macProcessor,
            'interest' => $this->faker->postcode,
            'date_of_birth' => Carbon::now()->subYears(mt_rand(18, 65))->toDateTimeString(),
            'email' => $this->faker->email,
            'account' => $this->faker->randomFloat(),
            'credit_card' => $this->faker->creditCardDetails,
            'record_key' => $this->faker->uuid // To mark record to be inserted as unique
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
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
