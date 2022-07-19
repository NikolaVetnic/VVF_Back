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
        $favoriteData = $request->only(['user_id', 'movie_id', 'watched']);

        $user = User::find($favoriteData['user_id']);
        $movie = Movie::find($favoriteData['movie_id']);

        $favorite = new Favorite();
        $favorite->watched = $favoriteData["watched"];
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
        $registerData = $request->only(['id']);

        // $favorite = Favorite::where('user_id', $registerData['user_id'])->where('movie_id', $registerData['movie_id'])->first();

        $favorite = Favorite::find($registerData['id']);
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
        $favoriteData = $request->only(['id']);
        // Favorite::where('user_id', $favoriteData['user_id'])->where('movie_id', $favoriteData['movie_id'])->delete();
        Favorite::destroy($favoriteData['id']);
    }

    public function indexByUser($id)
    {
        return Favorite::where('user_id', $id)->get();
    }
}
