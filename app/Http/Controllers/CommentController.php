<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $registerData = $request->only(['content', 'userId', 'movieId']);

        $user = User::where('id', $registerData['userId'])->first();
        $movie = Movie::where('id', $registerData['movieId'])->first();

        $comment = new Comment();
        $comment->content = $registerData['content'];
        $comment->user()->associate($user);
        $comment->movie()->associate($movie);
        $comment->save();

        return $comment;
    }
}
