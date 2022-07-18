<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reactionData = $request->only(['reaction', 'user_id', 'movie_id']);

        // $user = User::where('id', $registerData['userId'])->first();
        // $movie = Movie::where('id', $registerData['movieId'])->first();

        Reaction::where('user_id', $reactionData['user_id'])->where('movie_id', $reactionData['movie_id'])->delete();
        $reaction = Reaction::create($reactionData);

        // $reaction = new Reaction();
        // $reaction->reaction = $registerData['reaction'];
        // $reaction->user()->associate($user);
        // $reaction->movie()->associate($movie);
        // $reaction->save();

        return $reaction;
    }
}
