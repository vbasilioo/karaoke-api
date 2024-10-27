<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMusicQueue as JobsProcessMusicQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessMusicQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-music-queue';

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
        JobsProcessMusicQueue::dispatch();
    }
}
