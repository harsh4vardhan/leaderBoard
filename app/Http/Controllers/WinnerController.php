<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function getCurrentWinner()
    {
        $winner = Winner::latest('won_at')->first();
        
        if (!$winner) {
            return response()->json(['message' => 'No winner declared yet'], 404);
        }
    
        return response()->json($winner);
    }
}
