<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

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
        throw new Exception('Such reaction already exists');
        try {
            $reactionData = $request->only(['reaction', 'user_id', 'movie_id']);

            $reaction = Reaction::where('user_id', $reactionData['user_id'])->where('movie_id', $reactionData['movie_id'])->first();

            if ($reaction['reaction'] === $reactionData['reaction'])
                throw new InvalidArgumentException('Such reaction already exists');

            Reaction::where('user_id', $reactionData['user_id'])->where('movie_id', $reactionData['movie_id'])->delete();
            $reaction = Reaction::create($reactionData);

            return $reaction;
        } catch (Throwable $error) {
            Log::debug($error);
        }
    }
}
