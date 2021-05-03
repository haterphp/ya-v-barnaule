<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment_methonds = ['cash', 'non-cash'];
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(1000, 10000),
            'person_count' => $this->faker->numberBetween(1, 200),
            'payment_method' => [$payment_methonds[rand(0, 1)]]
        ];
    }
}
