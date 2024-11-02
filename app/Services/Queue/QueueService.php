<?php

namespace App\Services\Queue;

use App\Exceptions\ApiException;
use App\Models\Music;
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

    public function destroy(array $data): array {
        $music = Music::where(['user_id' => $data['id'], 'position' => $data['position']])->first();
    
        if(!$music)
            throw new ApiException('Música não encontrada na área de músicas.');
    
        $deleted = $music->delete();
    
        if(!$deleted)
            throw new ApiException('Erro ao remover música da área de músicas.');
    
        $queue = Queue::where(['user_id' => $data['id'], 'music_id' => $music->id])->delete();
    
        if (!$queue)
            throw new ApiException('Erro ao remover música da fila.');
    
        return [];
    }    
}
