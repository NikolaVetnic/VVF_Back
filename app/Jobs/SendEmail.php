<?php

namespace App\Jobs;

use App\Mail\MovieCreated;
use App\Models\Movie;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $movie;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Movie $movie, $email)
    {
        $this->movie = $movie;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::to($this->email)->send(new MovieCreated($this->movie));
        throw new Exception('My Exception');
    }
}
