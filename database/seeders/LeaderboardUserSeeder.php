<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaderboardUser;

class LeaderboardUserSeeder extends Seeder
{
    public function run()
    {
        LeaderboardUser::factory()->count(50)->create();
    }
}
