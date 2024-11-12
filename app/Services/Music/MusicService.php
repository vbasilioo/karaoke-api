<?php

namespace App\Services\Music;

use App\Exceptions\ApiException;
use App\Models\Music;
use App\Models\MusicStat;
use App\Models\Queue;
use App\Models\User;
use App\Services\Queue\QueueService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MusicService{

    public function __construct(protected QueueService $queueService){}

    public function store(array $data): array{
        $userExists = User::find($data['user_id']);
        if(!$userExists)
            throw new ApiException('O usuário não existe.');

        $existingMusic = Music::where('name', $data['name'])->first();

        if($existingMusic){
            $stats = MusicStat::firstOrNew(['music_id' => $existingMusic->id]);
            $stats->request_count++;
            $stats->save();

            $queue = Queue::create([
                'user_id' => $data['user_id'],
                'music_id' => $existingMusic->id,
            ]);

            if(!$queue)
                throw new ApiException('Erro ao adicionar música existente à fila.');
            

            return $existingMusic->toArray();
        }

        $data['position'] = Music::whereNull('deleted_at')->count() + 1;

        $music = Music::create($data);

        if(!$music)
            throw new ApiException('Erro ao adicionar nova música à fila.');
        
        MusicStat::create([
            'music_id' => $music->id,
            'request_count' => 1,
        ]);

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
            'q' => 'karaoke ' . $data['query'],
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

    public function adjustMusicQueue(): void {
        $musicsByUser = Music::select('user_id', 'id', 'name')
            ->orderBy('created_at')
            ->get()
            ->groupBy('user_id');
    
        $orderQueue = [];
        $hasMusic = true;
    
        while($hasMusic) {
            $hasMusic = false;
    
            foreach($musicsByUser as $userId => $musics) {
                if($musics->isNotEmpty()) {
                    $music = $musics->shift();
                    $orderQueue[] = $music;
    
                    $hasMusic = true;
                }
            }
        }
    
        foreach($orderQueue as $i => $music) {
            $music->update(['position' => $i + 1]);
        }
    }    
}
