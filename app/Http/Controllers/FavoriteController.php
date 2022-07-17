<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $registerData = $request->only(['userId', 'movieId', 'watched']);

        $user = User::where('id', $registerData['userId'])->first();
        $movie = Movie::where('id', $registerData['movieId'])->first();

        $favorite = new Favorite();
        $favorite->watched = $registerData["watched"];
        $favorite->user()->associate($user);
        $favorite->movie()->associate($movie);
        $favorite->save();

        return $favorite;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $registerData = $request->only(['userId', 'movieId']);

        $favorite = Favorite::where('user_id', $registerData['userId'])->where('movie_id', $registerData['movieId'])->first();
        $favorite['watched'] = $favorite['watched'] === 0 ? 1 : 0;
        $favorite->save();

        return $favorite;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $registerData = $request->only(['userId', 'movieId']);
        Favorite::where('user_id', $registerData['userId'])->where('movie_id', $registerData['movieId'])->delete();
    }

    public function indexByUser($id)
    {
        return Favorite::where('user_id', $id)->get();
    }
}
