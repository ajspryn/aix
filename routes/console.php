<?php

declare(strict_types=1);

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

// Schedule the AIX Telemetry Ingestion to run every minute autonomously to naturally fluctuate (increase/decrease) risks
Schedule::command('aix:ingest-telemetry')->everyMinute();

// Automatically scan for new disaster nodes every minute (Radar AIX)
Schedule::command('aix:scan-nodes', ['--count' => 1])->everyMinute();

// Evaluate and feedback post-mitigation (ROI logic) periodically
Schedule::command('aix:track-impact')->hourly();

// Ingest Gempa Real-time Eksternal dari BMKG
Schedule::command('aix:scan-quakes')->everyMinute();
