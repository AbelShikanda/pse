<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:generate-sitemap')->weekly();
Schedule::command('remove:unverified-users')->daily();
Schedule::command('remove:contacts')->daily();
Schedule::command('remove:promotions')->daily();
