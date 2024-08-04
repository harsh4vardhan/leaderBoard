<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeaderboardUser;

class ResetScores extends Command
{
    protected $signature = 'scores:reset';
    protected $description = 'Reset all leaderboard scores to zero';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        LeaderboardUser::query()->update(['points' => 0]);
        $this->info('All scores have been reset to zero.');
    }
}
