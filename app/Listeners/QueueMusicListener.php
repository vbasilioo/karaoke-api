<?php

namespace App\Listeners;

use App\Events\MusicCreated;
use Illuminate\Support\Facades\Log;

class QueueMusicListener
{
    /**
     * Handle the event.
     */
    public function handle(MusicCreated $event): void
    {
        Log::info('Nova música adicionada ao banco de dados.', [
            'id' => $event->music->id,
            'name' => $event->music->name,
            'description' => $event->music->description,
        ]);
    }
}
