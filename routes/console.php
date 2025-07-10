<?php

use App\Jobs\EmailsJob;
use App\Jobs\TasksNotificationJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Set every minute as example/test purpose only.
Schedule::job(new TasksNotificationJob)->everyMinute();
Schedule::job(new EmailsJob())->everyMinute();

// TODO: Prepare job to clear emails after 30 days if sent.
// TODO: Prepare job to clear expired shared tasks.
