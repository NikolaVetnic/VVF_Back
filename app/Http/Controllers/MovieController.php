<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Image as ModelsImage;
use App\Models\Movie;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::with('image')->get();
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
        $newMovie = new Movie();

        // =-=-=-=

        $url = $movieData['image_url'];

        $path = "/Users/nikolavetnic/Documents/Various Projects/vvf-project-back/storage/app/";
        $name_full = $path . "full-size/" . substr($url, strrpos($url, '/') + 1);
        $thumbnail = $path . "thumbnails/" . substr($url, strrpos($url, '/') + 1);

        Image::make($url)->resize(400, 400)->save($name_full);
        Image::make($url)->resize(200, 200)->save($thumbnail);

        $image = new ModelsImage();
        $image['full-size'] = $name_full;
        $image['thumbnail'] = $thumbnail;

        // =-=-=-=

        $movie = Movie::create($movieData);

        $image->movie()->associate($movie);
        $image->save();

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
