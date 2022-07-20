<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;

class AddMoviesToIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:addMoviesToIndex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add movies to index.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Movie::addAllToIndex();
    }
}
