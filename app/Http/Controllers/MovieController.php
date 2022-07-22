<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\MovieCreated;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Reaction;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image as InterventionImage;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MovieController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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
        $movieData = $request->only(['title', 'description', 'image_url', 'genre', 'admin']);

        $movie = Movie::create($movieData);
        $image = $request->file('file');

        $this->imageService->saveImage($movie, $image);

        // Mail::to($movieData['admin'])->send(new MovieCreated($movie));
        SendEmail::dispatch($movie, $movieData['admin']);

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
