<?php

namespace Database\Factories;

use App\Models\Gleanable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GleanableFactory extends Factory
{
    protected $model = Gleanable::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'icon' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
