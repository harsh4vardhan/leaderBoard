<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardUserController;
use App\Http\Controllers\WinnerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// routes/api.php

Route::get('/leaderboard-users', [LeaderboardUserController::class, 'index']);
Route::post('/leaderboard-users', [LeaderboardUserController::class, 'store']);
Route::get('/leaderboard-users/{leaderboardUser}', [LeaderboardUserController::class, 'show']);
Route::put('/leaderboard-users/{leaderboardUser}', [LeaderboardUserController::class, 'update']);
Route::delete('/leaderboard-users/{leaderboardUser}', [LeaderboardUserController::class, 'destroy']);
Route::get('/leaderboard-users/search', [LeaderboardUserController::class, 'search']);
Route::get('/leaderboard-users/sort/name', [LeaderboardUserController::class, 'sortByName']);
Route::get('/leaderboard-users/sort/points', [LeaderboardUserController::class, 'sortByPoints']);
Route::get('/leaderboard-users/group/score', [LeaderboardUserController::class, 'groupByScore']);
Route::get('/leaderboard-winner', [WinnerController::class, 'getCurrentWinner']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
