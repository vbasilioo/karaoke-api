<?php

namespace App\Jobs;

use App\Models\Music;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMusicQueue implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("===> AJUSTANDO FILA IGUALITÁRIA DE MÚSICAS <===");

        $musicsByUser = Music::select('user_id', 'id', 'name')->orderBy('created_at')->get()->groupBy('user_id');

        $orderQueue = [];

        $hasMusic = true;

        while($hasMusic){
            $hasMusic = false;

            foreach($musicsByUser as $userId => $musics){
                if($musics->isNotEmpty()){
                    $orderQueue[] = $musics->shift();
                    $hasMusic = true;
                }
            }
        }

        foreach($orderQueue as $i => $music){
            $music->update(['position' => $i + 1]);
        }

        Log::info("===> FILA IGUALITÁRIA DE MÚSICAS AJUSTADA <===");
    }
}
