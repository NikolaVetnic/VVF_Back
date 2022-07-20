<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Movie extends Model
{
    use HasFactory, ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'genre',
        'num_visits'
    ];

    protected $appends = ['likes', 'dislikes'];

    /**
     * Defines number of likes for movie.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function likes(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->reactions()->where('reaction', 'like')->count()
        );
    }

    /**
     * Defines number of dislikes for movie.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dislikes(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->reactions()->where('reaction', 'dislike')->count()
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sorted_comments()
    {
        return $this->with('user')->comments()->orderBy('created_at', 'desc')->get();
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function favorites()
    {
        return $this->hasMany(Reaction::class);
    }
}
