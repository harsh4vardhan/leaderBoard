<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = ['leaderboard_user_id', 'points', 'won_at','name'];

    public function leaderboardUser()
    {
        return $this->belongsTo(LeaderboardUser::class);
    }
}
