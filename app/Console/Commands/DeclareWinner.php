<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeaderboardUser;
use App\Models\Winner;
use Carbon\Carbon;

class DeclareWinner extends Command
{
    protected $signature = 'winner:declare';
    protected $description = 'Declare the user with the highest points as the winner';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $highestScoringUsers = LeaderboardUser::orderBy('points', 'desc')->take(2)->get();

        if ($highestScoringUsers->count() < 2 || $highestScoringUsers[0]->points != $highestScoringUsers[1]->points) {
            Winner::create([
                'leaderboard_user_id' => $highestScoringUsers[0]->id,
                'points' => $highestScoringUsers[0]->points,
                'won_at' => Carbon::now(),
            ]);
            $this->info('Winner declared.');
        } else {
            $this->info('No winner declared due to tie.');
        }
    }
}
