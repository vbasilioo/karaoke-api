<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'hour_start',
        'hour_end',
        'date_show',
        'type',
        'admin_id',
        'code_access'
    ];

    public function administrator(){
        return $this->belongsTo(Administrator::class);
    }
}
