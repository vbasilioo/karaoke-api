<?php

use App\Jobs\ProcessMusicQueue;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ProcessMusicQueue(), 'app:process-music-queue')->everySecond();
