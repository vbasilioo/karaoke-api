<?php

namespace App\Services\Music;

use App\Exceptions\ApiException;
use App\Models\Music;
use App\Models\Queue;
use App\Models\User;
use App\Services\Queue\QueueService;
use Illuminate\Support\Facades\Http;

class MusicService{

    public function __construct(protected QueueService $queueService){}

    public function store(array $data): array{
        $userExists = User::find($data['user_id']);
        if(!$userExists)
            throw new ApiException('O usuário não existe.');

        $music = Music::create($data);
        if(!$music)
            throw new ApiException('Erro ao adicionar música a fila.');

        $existsMusic = Music::find($music->id);
        if(!$existsMusic)
            throw new ApiException('A música não foi encontrada.');

        $queue = Queue::create([
            'user_id' => $data['user_id'],
            'music_id' => $music->id,
        ]);

        if(!$queue)
            throw new ApiException('Erro ao adicionar usuário na fila.');

        return $music->toArray();
    }

    public function index(): array{
        $music = Music::with('user')->get();

        if(!$music)
            throw new ApiException('Nenhuma música na fila.');

        return $music->toArray();
    }

    public function search(array $data): array{
        $music = Http::youtube()->get('/search', [
            'part' => 'snippet',
            'q' => $data['query'],
            'type' => 'video',
            'maxResults' => 50,
            'key' => env('API_YOUTUBE_KEY')
        ]);

        if(!$music)
            throw new ApiException('Nenhuma música encontrada.');

        return $music->json();
    }

    public function getDetails(array $data): array{
        $music = Http::youtube()->get('/videos', [
            'part' => 'snippet,contentDetails,statistics',
            'id' => $data['video_id'],
            'key' => env('API_YOUTUBE_KEY')
        ]);

        if(!$music)
            throw new ApiException('Não há detalhes para a música.');

        return $music->json();
    }

    public function getDetailsChannel(array $data): array{
        $music = Http::youtube()->get('/channels', [
            'part' => 'snippet,statistics,contentDetails',
            'id' => $data['channel_id'],
            'key' => env('API_YOUTUBE_KEY'),
        ]);

        if(!$music)
            throw new ApiException('Não há detalhes para o canal.');

        return $music->json();
    }

    public function nextMusic(): array{
        $music = Music::oldest()->first();

        if(!$music)
            throw new ApiException('Nenhuma música disponível.');

        return $music->toArray();
    }
}
