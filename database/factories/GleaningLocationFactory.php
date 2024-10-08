<?php

namespace Database\Factories;

use App\Models\Gleanable;
use App\Models\GleaningLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GleaningLocationFactory extends Factory
{
    protected $model = GleaningLocation::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'gleanable_id' => Gleanable::factory(),
            'description' => $this->faker->sentence,
            // Coordinates in belgium
            'latitude' => $this->faker->latitude(50.5, 51.5),
            'longitude' => $this->faker->longitude(3.5, 4.5),
            'postal_code' => 4280,
            'city' => $this->faker->city,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'files' => ['https://placehold.co/600x400', 'https://placehold.co/500x500'],
        ];
    }
}
