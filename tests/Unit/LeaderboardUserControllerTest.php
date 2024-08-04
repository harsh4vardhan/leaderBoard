<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\LeaderboardUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\GenerateQRCode;

class LeaderboardUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_users_sorted_by_points()
    {
        $user1 = LeaderboardUser::factory()->create(['points' => 10]);
        $user2 = LeaderboardUser::factory()->create(['points' => 20]);

        $response = $this->get('/api/leaderboard-users');

        $response->assertStatus(200)
                 ->assertJson([
                     ['id' => $user2->id, 'points' => 20],
                     ['id' => $user1->id, 'points' => 10],
                 ]);
    }

    /** @test */
    public function it_can_store_a_new_user()
    {
        Queue::fake();

        $response = $this->post('/api/leaderboard-users', [
            'name' => 'John Doe',
            'age' => 30,
            'address' => '123 Street',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'John Doe',
                     'age' => 30,
                     'address' => '123 Street',
                 ]);

        Queue::assertPushed(GenerateQRCode::class);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = LeaderboardUser::factory()->create();

        $response = $this->get("/api/leaderboard-users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'name' => $user->name,
                     'age' => $user->age,
                     'address' => $user->address,
                     'points' => $user->points,
                 ]);
    }

    /** @test */
    public function it_can_update_user_points()
    {
        $user = LeaderboardUser::factory()->create(['points' => 10]);

        $response = $this->put("/api/leaderboard-users/{$user->id}", [
            'points' => 5,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'points' => 15, // 10 + 5
                 ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = LeaderboardUser::factory()->create();
    
        $response = $this->delete("/api/leaderboard-users/{$user->id}");
    
        $response->assertStatus(204);
        $this->assertDatabaseMissing('leaderboard_users', ['id' => $user->id]);
    }

   

    /** @test */
    public function it_can_sort_users_by_name()
    {
        $user1 = LeaderboardUser::factory()->create(['name' => 'Charlie']);
        $user2 = LeaderboardUser::factory()->create(['name' => 'Alice']);

        $response = $this->get('/api/leaderboard-users/sort/name');

        $response->assertStatus(200)
                 ->assertJson([
                     ['id' => $user2->id, 'name' => 'Alice'],
                     ['id' => $user1->id, 'name' => 'Charlie'],
                 ]);
    }

    /** @test */
    public function it_can_sort_users_by_points()
    {
        $user1 = LeaderboardUser::factory()->create(['points' => 10]);
        $user2 = LeaderboardUser::factory()->create(['points' => 20]);

        $response = $this->get('/api/leaderboard-users/sort/points');

        $response->assertStatus(200)
                 ->assertJson([
                     ['id' => $user2->id, 'points' => 20],
                     ['id' => $user1->id, 'points' => 10],
                 ]);
    }

    /** @test */
    public function it_can_group_users_by_score()
    {
        $user1 = LeaderboardUser::factory()->create(['points' => 10, 'name' => 'Alice', 'age' => 30]);
        $user2 = LeaderboardUser::factory()->create(['points' => 10, 'name' => 'Bob', 'age' => 40]);

        $response = $this->get('/api/leaderboard-users/group/score');

        $response->assertStatus(200)
                 ->assertJson([
                     '10' => [
                         'names' => ['Alice', 'Bob'],
                         'average_age' => 35,
                     ],
                 ]);
    }
}
