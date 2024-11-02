<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'musics';

    protected $fillable = [
        'name',
        'description',
        'video_id',
        'user_id',
        'show_id',
        'position'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function musicStat(){
        return $this->hasMany(MusicStat::class);
    }
}
