<?php

namespace App\Console\Commands;

use App\Services\Music\MusicService;
use Illuminate\Console\Command;

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

    public $musicService;

    public function __construct(MusicService $musicService)
    {
        parent::__construct();
        $this->musicService = $musicService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while(true){
            $this->musicService->processCurrentMusic();
            sleep(1);
        }
    }
}
