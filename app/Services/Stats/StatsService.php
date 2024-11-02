<?php

namespace App\Services\Stats;

use App\Models\MusicStat;

class StatsService{
    public function index(array $data): object{
        return MusicStat::with('music')->paginate($data['per_page'], ['*'], 'page', $data['page']);
    }
}