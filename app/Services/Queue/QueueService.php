<?php

namespace App\Services\Queue;

use App\Exceptions\ApiException;
use App\Models\Queue;

class QueueService{
    public function index(): array{
        $queues = Queue::with('user')->with('music')->get();

        if(!$queues)
            throw new ApiException('Nenhuma fila encontrada.');

        return $queues->toArray();
    }

    public function organizationQueue(){
        $queues = Queue::with('music')->orderBy('id')->get()->groupBy('user_id');

        if(!$queues)
            throw new ApiException('Nenhuma fila encontrada.');

        $equalQueue = collect();

        $maxSongs = $queues->max(function ($queue){
            return $queue->count();
        });

        Queue::truncate();
        foreach($equalQueue as $item){
            Queue::create([
                'user_id' => $item->user_id,
                'music_id' => $item->music_id,
            ]);
        }
    }
}
