<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MusicStat extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'music_id',
        'play_count',
        'request_count'
    ];

    public function music(){
        return $this->belongsTo(Music::class);
    }
}
