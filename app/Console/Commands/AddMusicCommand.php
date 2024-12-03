<?php

namespace App\Console\Commands;

use App\Jobs\AddMusicJob;
use Illuminate\Console\Command;

class AddMusicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-music-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AddMusicJob::dispatch();
    }
}
