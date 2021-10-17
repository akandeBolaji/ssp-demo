<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'from' => $this->faker->date(),
            'to' => $this->faker->date(),
            'total_budget' => $this->faker->randomDigit,
            'daily_budget' => $this->faker->randomDigit
        ];
    }
}
