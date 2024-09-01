<?php

namespace Database\Factories;

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
            'description' => $this->faker->sentence,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
