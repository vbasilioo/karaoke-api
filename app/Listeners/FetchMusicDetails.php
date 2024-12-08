<?php

namespace App\Listeners;

use App\Events\EndMusicEvent;
use App\Exceptions\ApiException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class FetchMusicDetails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EndMusicEvent $event): void
    {
        $music = Http::youtube()->get('/videos', [
            'part' => 'snippet,contentDetails,statistics',
            'id' => $event->musicDetails['video_id'],
            'key' => env('API_YOUTUBE_KEY')
        ]);

        if(!$music)
            throw new ApiException('Não há detalhes para a música.');

        $musicData = $music->json();

        if (isset($musicData['items']) && is_array($musicData['items'])) {
            foreach ($musicData['items'] as &$item) {
                if (isset($item['contentDetails']['duration'])) {
                    $duration = $item['contentDetails']['duration'];
                    $convertedDuration = $this->convertDuration($duration);
                    $item['contentDetails']['duration_time'] = $convertedDuration['formatted'];
                    $item['contentDetails']['duration_seconds'] = $convertedDuration['seconds'];

                    sleep($convertedDuration['seconds']);
                    broadcast(new EndMusicEvent($item));
                }
            }
        }
    }

    private function convertDuration(string $duration): array {
        $duration = str_replace('PT', '', $duration);
    
        $minutes = 0;

        $seconds = 0;
    
        if(preg_match('/(\d+)M/', $duration, $matches))
            $minutes = (int)$matches[1];
        

        if(preg_match('/(\d+)S/', $duration, $matches))
            $seconds = (int)$matches[1];
        
    
        $totalSeconds = ($minutes * 60) + $seconds;
    
        $formattedDuration = sprintf('%02d:%02d', $minutes, $seconds);
    
        return [
            'formatted' => $formattedDuration,
            'seconds' => $totalSeconds
        ];
    }
}
