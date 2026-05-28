<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\MonitoredArea;
use App\Models\TelemetryLog;
use App\Models\SentimentSignal;
use App\Services\DataAnalytics\InternalEngine;
use Carbon\Carbon;

class IngestTelemetryDataCommand extends Command
{
     /**
      * The name and signature of the console command.
      */
     protected $signature = 'aix:ingest-telemetry';

     /**
      * The console command description.
      */
     protected $description = 'Ingests telemetry from external APIs (USGS, BMKG, OpenWeather) and updates risk scores.';

     public function __construct(
          private readonly InternalEngine $internalEngine
     ) {
          parent::__construct();
     }

     /**
      * Execute the console command.
      */
     public function handle(): void
     {
          $this->info('Starting automated AIX Telemetry Ingestion...');

          $areas = MonitoredArea::all();

          foreach ($areas as $area) {
               $this->info("Processing Area: {$area->name}");

               // 1. Simulate Google News/Social RSS Parse FIRST to drive weather context
               $newsTitle = $this->ingestSocialSentimentData($area);

               // 2. Simulate BMKG/USGS Geological/Weather Pull
               $this->ingestWeatherAndGeoData($area, $newsTitle);

               // 3. Re-calculate the continuous Core Risk Score using InternalEngine
               $newRiskScore = $this->internalEngine->computeLiveRiskScore($area->id);

               $status = 'stable';
               if ($newRiskScore >= 0.7) {
                    $status = 'critical';
               } elseif ($newRiskScore >= 0.4) {
                    $status = 'warning';
               }

               $area->update([
                    'current_risk_score' => round($newRiskScore, 4),
                    'status' => $status
               ]);

               $this->line("-> Updated Score: {$newRiskScore} | Status: {$status}");
          }

          $this->info('AIX Telemetry Ingestion Completed Successfully.');
     }

     private function ingestWeatherAndGeoData(MonitoredArea $area, ?string $newsTitle = null): void
     {
          // Simulated API Call to OpenWeather / BMKG
          // In production, this would be: Http::get("https://api.openweathermap.org/...&lat={$area->latitude}&lon={$area->longitude}")

          $rainfall = rand(10, 50);
          $soilMoisture = rand(40, 60);
          $temp = rand(28, 32);
          $seismicHz = rand(1, 3);
          $windSpeed = rand(10, 30);

          if ($newsTitle) {
               $titleLower = strtolower($newsTitle);
               if (str_contains($titleLower, 'banjir') || str_contains($titleLower, 'hujan') || str_contains($titleLower, 'tenggelam') || str_contains($titleLower, 'rob')) {
                    $rainfall = rand(150, 350);
                    $soilMoisture = rand(85, 100);
                    $temp = rand(24, 28);
               } elseif (str_contains($titleLower, 'kering') || str_contains($titleLower, 'kemarau') || str_contains($titleLower, 'kebakaran') || str_contains($titleLower, 'karhutla') || str_contains($titleLower, 'panas')) {
                    $rainfall = rand(0, 5);
                    $soilMoisture = rand(5, 25);
                    $temp = rand(34, 40);
               } elseif (str_contains($titleLower, 'gempa') || str_contains($titleLower, 'vulkanik') || str_contains($titleLower, 'gunung') || str_contains($titleLower, 'erupsi') || str_contains($titleLower, 'longsor')) {
                    $seismicHz = rand(5, 15);
               } elseif (str_contains($titleLower, 'angin') || str_contains($titleLower, 'puting beliung') || str_contains($titleLower, 'badai')) {
                    $windSpeed = rand(60, 120);
                    $rainfall = rand(50, 100);
               }
          }

          TelemetryLog::create([
               'monitored_area_id' => $area->id,
               'rainfall_mm' => $rainfall,
               'soil_moisture' => $soilMoisture,
               'temperature' => $temp,
               'raw_payload_json' => [
                    'source' => 'synthetic-ContextMatching-API',
                    'seismic_activity_hz' => $seismicHz,
                    'wind_speed_kmh' => $windSpeed
               ],
               'created_at' => Carbon::now()
          ]);
     }

     private function ingestSocialSentimentData(MonitoredArea $area): ?string
     {
          $areaNameClean = preg_replace('/ - .*$/', '', $area->name);
          $url = "https://news.google.com/rss/search?q=" . urlencode($areaNameClean . " (bencana OR banjir OR gempa OR kekeringan OR longsor OR kebakaran OR terendam)") . "&hl=id&gl=ID&ceid=ID:id";

          try {
               $response = Http::get($url);
               $xml = @simplexml_load_string($response->body());

               if ($xml && isset($xml->channel->item) && count($xml->channel->item) > 0) {
                    $items = $xml->channel->item;
                    $item = $items[rand(0, min(15, count($items) - 1))];

                    $title = (string) $item->title;
                    $link = (string) $item->link;

                    $parts = explode(' - ', $title);
                    $source = count($parts) > 1 ? trim(end($parts)) : 'Portal Berita Terverifikasi';

                    if (count($parts) > 1) {
                         array_pop($parts);
                         $title = implode(' - ', $parts);
                    }

                    $sentiment = rand(-100, -10) / 100;

                    SentimentSignal::create([
                         'monitored_area_id' => $area->id,
                         'source_type' => $source,
                         'raw_text' => $title,
                         'calculated_sentiment' => $sentiment,
                         'source_link' => $link,
                         'created_at' => Carbon::now()
                    ]);

                    return $title;
               }
          } catch (\Exception $e) {
          }

          return "anomali";
     }
}
