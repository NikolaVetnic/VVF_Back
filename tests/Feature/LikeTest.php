<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $user = User::inRandomOrder()->first();
        $movie = Movie::inRandomOrder()->first();

        Reaction::where('user_id', $user['id'])->where('movie_id', $movie['id'])->delete();
        $reaction = Reaction::where('user_id', $user['id'])->where('movie_id', $movie['id'])->first();

        $this->assertNull($reaction);

        $reactionData = array('user_id' => $user['id'], 'movie_id' => $movie['id'], 'reaction' => 'like');
        Reaction::create($reactionData);

        $reaction = Reaction::where('user_id', $user['id'])->where('movie_id', $movie['id'])->first();

        $this->assertTrue($reaction != null && $reaction['reaction'] === 'like');
    }

    /**
     * @expectedException Exception
     */
    public function test_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $user = User::inRandomOrder()->first();
        $movie = Movie::inRandomOrder()->first();

        Reaction::where('user_id', $user['id'])->where('movie_id', $movie['id'])->delete();
        $reaction = Reaction::where('user_id', $user['id'])->where('movie_id', $movie['id'])->first();

        $this->assertNull($reaction);

        $reactionData = array('user_id' => $user['id'], 'movie_id' => $movie['id'], 'reaction' => 'like');
        Reaction::create($reactionData);
        Reaction::create($reactionData);
    }
}
