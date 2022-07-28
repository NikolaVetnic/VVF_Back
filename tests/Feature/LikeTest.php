<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_like()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $response = $this->postJson('/api/reactions/store', [
            'user_id' => $user['id'],
            'movie_id' => $movie['id'],
            'reaction' => 'like'
        ]);

        $response->assertSuccessful();

        Reaction::find($response->json('id'));
    }

    /**
     * @expectedException Exception
     */
    public function test_exception()
    {
        $this->expectErrorMessage('Object of class Illuminate\Testing\TestResponse could not be converted to string');

        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $response = $this->postJson('/api/reactions/store', [
            'user_id' => $user['id'],
            'movie_id' => $movie['id'],
            'reaction' => 'like'
        ]);

        $response = $this->postJson('/api/reactions/store', [
            'user_id' => $user['id'],
            'movie_id' => $movie['id'],
            'reaction' => 'like'
        ]);

        Log::debug($response);
    }
}
