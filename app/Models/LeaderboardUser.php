<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardUser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'points', 'address'];

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
