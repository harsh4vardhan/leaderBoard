<?php

// app/Http/Controllers/LeaderboardUserController.php

namespace App\Http\Controllers;

use App\Models\LeaderboardUser;
use Illuminate\Http\Request;
use App\Jobs\GenerateQRCode;

class LeaderboardUserController extends Controller
{
    public function index()
    {
        return LeaderboardUser::orderBy('points', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'address' => 'required|string|max:255',
        ]);
    
        $user = LeaderboardUser::create($validatedData);
    
        // Dispatch the job to generate QR code
        GenerateQRCode::dispatch($user);
    
        return $user;
    }

    public function show(LeaderboardUser $leaderboardUser)
    {
        return $leaderboardUser;
    }

    public function update(Request $request, LeaderboardUser $leaderboardUser)
    {
        $validatedData = $request->validate([
            'points' => 'required|integer', 
        ]);
    
        $newPoints = $leaderboardUser->points + $validatedData['points'];
    
        $newPoints = max($newPoints, 0);
    
        $leaderboardUser->update(['points' => $newPoints]);
    
        return response()->json($leaderboardUser);
    }
    
    

    public function destroy(LeaderboardUser $leaderboardUser)
    {
        $leaderboardUser->delete();

        return response()->noContent();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        return LeaderboardUser::where('name', 'like', "%{$query}%")->get();
    }

    public function sortByName()
    {
        return LeaderboardUser::orderBy('name')->get();
    }

    public function sortByPoints()
    {
        return LeaderboardUser::orderBy('points', 'desc')->get();
    }

    public function groupByScore()
    {
        $users = LeaderboardUser::select('points', 'name', 'age')
            ->get()
            ->groupBy('points')
            ->map(function ($group) {
                return [
                    'names' => $group->pluck('name'),
                    'average_age' => $group->avg('age'),
                ];
            });

        return response()->json($users);
    }
}
