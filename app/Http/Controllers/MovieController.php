<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Movie;
use App\Models\Reaction;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $registerData = $request->only(['title', 'description', 'imageUrl', 'genre']);
        $movie = Movie::create($registerData);

        return $movie;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reactions = Reaction::where('movie_id', $id)->get();
        $movie = Movie::find($id);

        $movie['likes'] = $reactions->where('reaction', 'like')->count();
        $movie['dislikes'] = $reactions->where('reaction', 'dislike')->count();

        return $movie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Movie::destroy($id);
    }

    public function addVisit($id)
    {
        Movie::where('id', $id)->increment('num_visits');
        $movie = Movie::find($id);

        return $movie;
    }

    public function indexComments($id)
    {
        return Comment::with('user')->where('movie_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function best()
    {
        $movies = Movie::all();

        foreach ($movies as $movie) {
            $reactions = Reaction::where('movie_id', $movie['id'])->get();
            $movie['likes'] = $reactions->where('reaction', 'like')->count();
            $movie['dislikes'] = $reactions->where('reaction', 'dislike')->count();
        }

        $movies = $movies->sortByDesc('likes')->values()->all();

        return array_slice($movies, 0, 10);
    }
}
