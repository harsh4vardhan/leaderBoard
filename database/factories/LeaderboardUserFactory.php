<?php

namespace Database\Factories;

use App\Models\LeaderboardUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LeaderboardUserFactory extends Factory
{
    protected $model = LeaderboardUser::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->numberBetween(18, 60),
            'points' => 0,
            'address' => $this->faker->address,
        ];
    }
}
