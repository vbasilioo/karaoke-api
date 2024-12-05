<?php

namespace App\Events;

use App\Models\Music;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddMusicEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $orderQueue;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->orderQueue = $this->generateOrderQueue();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('add-music'),
        ];
    }

    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'orderQueue' => $this->orderQueue,
        ];
    }

    /**
     * Generate the order queue for broadcasting.
     *
     * @return array
     */
    private function generateOrderQueue(): array
    {
        $musicsByUser = Music::select('user_id', 'id', 'name')
            ->orderBy('created_at')
            ->get()
            ->groupBy('user_id');

        $orderQueue = [];
        $hasMusic = true;

        while ($hasMusic) {
            $hasMusic = false;

            foreach ($musicsByUser as $userId => $musics) {
                if ($musics->isNotEmpty()) {
                    $music = $musics->shift();
                    $orderQueue[] = $music;

                    $hasMusic = true;
                }
            }
        }

        foreach ($orderQueue as $i => $music) {
            $music->update(['position' => $i + 1]);
        }

        return array_map(function ($music) {
            return $music->toArray();
        }, $orderQueue);
    }
}
