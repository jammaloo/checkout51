<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'batch_id' => rand(0,10),
            'name' => $this->faker->name,
            'image_url' => $this->faker->imageUrl(),
            'cash_back' => rand(1,10000),
        ];
    }
}
