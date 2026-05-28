<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\MonitoredArea;
use App\Models\ImpactContract;
use App\Models\TelemetryLog;
use App\Services\Alerting\SystemAlertService;
use Carbon\Carbon;

class ScanBmkgQuakesCommand extends Command
{
    protected $signature = 'aix:scan-quakes';
    protected $description = 'Ingest data gempa bumi terkini dari BMKG dan update state Monitored Areas terdekat.';

    public function handle()
    {
        $this->info("Menghubungkan ke Feed Satelit Gempa BMKG TEWS...");

        try {
            $response = Http::timeout(5)->get('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
            if (!$response->successful()) {
                $this->error("Gagal menarik data dari BMKG.");
                return;
            }

            $data = $response->json();
            $gempa = $data['Infogempa']['gempa'] ?? null;

            if (!$gempa) {
                $this->error("Format data BMKG tidak sesuai.");
                return;
            }

            $coords = explode(',', $gempa['Coordinates']);
            $quakeLat = (float) trim($coords[0]);
            $quakeLng = (float) trim($coords[1]);
            $magnitude = (float) $gempa['Magnitude'];
            $wilayah = $gempa['Wilayah'];
            $potensi = $gempa['Potensi'];

            $this->info("Gempa Terdeteksi: M{$magnitude} di {$wilayah}");

            if ($magnitude < 5.0) {
                 $this->info("Magnitudo di bawah 5.0, mengabaikan eskalasi krisis darurat.");
                 return;
            }

            $areas = MonitoredArea::all();
            $impactedNodes = 0;

            foreach ($areas as $area) {
                 $distance = $this->calculateDistance($quakeLat, $quakeLng, (float)$area->latitude, (float)$area->longitude);

                 // Radius dampak agresif untuk AIX: M>6 = radius 300km, M>5 = 150km
                 $radius = $magnitude >= 6.0 ? 300 : 150;

                 if ($distance <= $radius) {
                      $impactedNodes++;
                      $this->warn("Dampak Terdeteksi: Area Node {$area->name} berjarak " . round($distance) . " km dari episentrum!");

                      // Suntik Data Telemetri Paksa
                      TelemetryLog::create([
                          'monitored_area_id' => $area->id,
                          'rainfall_mm' => 0,
                          'soil_moisture' => 0,
                          'temperature' => 0,
                          'raw_payload_json' => [
                              'sensor_ping' => 'EARTHQUAKE_OVERRIDE',
                              'data_source' => 'BMKG_TEWS',
                              'magnitude' => $magnitude,
                              'distance_km' => $distance,
                          ],
                          'created_at' => Carbon::now(),
                      ]);

                      // Force update risk mengabaikan Z-Score normal (Karena ini The Black Swan Event)
                      $area->update([
                          'current_risk_score' => 1.0,
                          'status' => 'critical'
                      ]);

                      // Cek jika sudah ada kontrak open/pending agar tidak duplikat
                      $existing = ImpactContract::where("monitored_area_id", $area->id)
                          ->whereIn("status", ["open", "pending", "state_lock"])
                          ->first();

                      if (!$existing) {
                          $contract = ImpactContract::create([
                              'monitored_area_id' => $area->id,
                              'worst_case_scenario' => "OVERRIDE DARURAT BENACANA SENSOR BMKG: Gempa M{$magnitude} berjarak " . round($distance) . " km dari lokasi ini. ({$wilayah}). Potensi Kerusakan Infrastruktur Masif.",
                              'automated_mitigation_plan' => "TANGGAP DARURAT BENCANA NASIONAL: Evakuasi SAR gabungan, pendirian RS lapangan, obat-obatan trauma, dan logistik berat.",
                              'estimated_funding_needed' => mt_rand(100, 500) * 10000000, 
                              'current_pooled_funds' => 0,
                              'financial_tier' => 3, // Tier 3 biasanya State Intervention required (Tertinggi)
                              'status' => 'state_lock', // Langsung di-lock untuk validasi intervensi pemerintah
                          ]);
                      } else {
                          // Jika sudah ada kontrak, naikkan statusnya ke State Lock
                          $existing->update([
                              'status' => 'state_lock',
                              'worst_case_scenario' => "ESKALASI DARURAT: " . $existing->worst_case_scenario . " | DIPERTAJAM OLEH GEMPA BUMI BMKG M{$magnitude} JARAK " . round($distance) . "KM.",
                              'financial_tier' => 3
                          ]);
                      }

                      // Picu Webhook Alerting (Slack/Escrow mock)
                      SystemAlertService::notifyCriticalZone($area->name . " (GEMPA M{$magnitude} - OVERRIDE AKTIF)", 1.0);
                 }
            }

            if ($impactedNodes > 0) {
                 $this->info("Force-Override Black Swan berhasil diimplementasikan ke $impactedNodes area.");
            } else {
                 $this->info("Episentrum gempa saat ini aman dari jangkauan area pantauan satelit AIX.");
            }

        } catch (\Exception $e) {
            $this->error("API BMKG Gagal Menerima Request atau Timeout: " . $e->getMessage());
        }
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance; 
    }
}
