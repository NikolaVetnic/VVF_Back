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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query('term');

        if ($searchQuery === null)
            return Movie::all();

        return Movie::searchByQuery(array('match' => array('title' => $searchQuery)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movieData = $request->only(['title', 'description', 'image_url', 'genre']);
        $movie = Movie::create($movieData);

        return $movieData;
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

    public function getComments($id)
    {
        // ovo mi vraca korisnike sa komentarima, metod iz Eloquent modela ne
        return Comment::with('user')->where('movie_id', $id)->orderBy('created_at', 'desc')->get();
        // return Movie::find($id)->sorted_comments();
    }

    public function best()
    {
        return Movie::all()->sortByDesc('likes')->values()->take(10);
    }

    public function genre($genre)
    {
        return Movie::where('genre', $genre)->get();
    }
}
