<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Movie;
use Image as InterventionImage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    public static function saveImage(Movie $movie, UploadedFile $image)
    {
        $name_stub = Str::random(16);

        $ext = $image->getClientOriginalExtension() ?: $image->guessExtension();

        $name_full = 'uploads/movie/full_size/' . $name_stub . "_full." . $ext;
        $name_thumb = 'uploads/movie/thumbnail/' . $name_stub . "_thumb." . $ext;

        InterventionImage::make($image)->resize(400, 400)->save($name_full);
        InterventionImage::make($image)->resize(200, 200)->save($name_thumb);

        Image::create(['full_size' => $name_full, 'thumbnail' => $name_thumb, 'movie_id' => $movie->id]);
    }
}
