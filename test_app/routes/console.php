<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CleanExpiredFiles;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('files:clean-expired', function(){
   $cmd = new CleanExpiredFiles();
   $cmd->handle();
})->purpose("Delete old files")->daily();
