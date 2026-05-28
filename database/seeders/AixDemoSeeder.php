<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MonitoredArea;
use App\Models\TelemetryLog;
use App\Models\MarketPrice;
use App\Models\SentimentSignal;
use App\Models\ImpactContract;
use App\Models\RiskEvidenceAttachment;
use Carbon\Carbon;

class AixDemoSeeder extends Seeder
{
     public function run(): void
     {
          // 1. Create System Admin and Regular User
          $admin = User::create([
               'name' => 'Komandan AIX',
               'email' => 'admin@aix.gov',
               'password' => Hash::make('password'),
               'role' => 'admin',
          ]);

          $user = User::create([
               'name' => 'Donatur Publik',
               'email' => 'donor@example.com',
               'password' => Hash::make('password'),
               'role' => 'user',
          ]);

          // 2. Create Monitored Areas
          $area1 = MonitoredArea::create([
               'name' => 'Sektor 4 Gunung Merapi',
               'latitude' => -7.5407,
               'longitude' => 110.4457,
               'current_risk_score' => 0.85,
               'type' => 'geological',
               'base_population' => 45000,
               'farm_acreage' => 1200.5,
               'status' => 'critical',
          ]);

          $area2 = MonitoredArea::create([
               'name' => 'Kawasan Pertanian Subang',
               'latitude' => -6.5686,
               'longitude' => 107.7611,
               'current_risk_score' => 0.45,
               'type' => 'agriculture',
               'base_population' => 125000,
               'farm_acreage' => 8500.0,
               'status' => 'warning',
          ]);

          $area3 = MonitoredArea::create([
               'name' => 'Zona Pesisir A Jakarta',
               'latitude' => -6.1214,
               'longitude' => 106.7901,
               'current_risk_score' => 0.15,
               'type' => 'economic',
               'base_population' => 300000,
               'farm_acreage' => 0,
               'status' => 'stable',
          ]);

          // 3. Inject Telemetry Data for Area 1
          for ($i = 0; $i < 5; $i++) {
               TelemetryLog::create([
                    'monitored_area_id' => $area1->id,
                    'rainfall_mm' => rand(150, 250),
                    'soil_moisture' => rand(70, 95),
                    'temperature' => rand(30, 45),
                    'raw_payload_json' => ['seismic_activity_hz' => rand(4, 9), 'sulfur_dioxide_ppm' => rand(100, 300)],
                    'created_at' => Carbon::now()->subHours($i * 4),
               ]);
          }

          // 4. Inject Attachments (Menggunakan foto asli Gunung Merapi)
          RiskEvidenceAttachment::create([
               'monitored_area_id' => $area1->id,
               'file_type' => 'satellite_img',
               'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Merapi_eruption_2010.jpg/800px-Merapi_eruption_2010.jpg',
               'description' => 'Visual observasi darat: Peningkatan aktivitas vulkanik Gunung Merapi dengan erupsi abu pekat.'
          ]);

          RiskEvidenceAttachment::create([
               'monitored_area_id' => $area1->id,
               'file_type' => 'satellite_img',
               'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Merapi_Volcano_and_Yogyakarta%2C_Indonesia_%2845344319524%29.jpg/800px-Merapi_Volcano_and_Yogyakarta%2C_Indonesia_%2845344319524%29.jpg',
               'description' => 'Citra satelit Copernicus mendeteksi sebaran titik panas di area kubah lava.'
          ]);

          // 5. Create Impact Contracts
          $contract1 = ImpactContract::create([
               'monitored_area_id' => $area1->id,
               'worst_case_scenario' => 'Erupsi vulkanik menghancurkan sektor 4. Pengungsian massal dan kegagalan panen agrikultur.',
               'automated_mitigation_plan' => 'Pengerahan instan logistik masker filtrasi, transportasi evakuasi darurat, dan relokasi ternak warga.',
               'estimated_funding_needed' => 750000000, // 750 Million IDR
               'current_pooled_funds' => 0,
               'monitored_area_id' => $area2->id,
               'worst_case_scenario' => 'Kekeringan berkepanjangan menyebabkan 80% gagal panen pada kuartal depan.',
               'automated_mitigation_plan' => 'Instalasi cepat 5 pompa air dalam bertenaga surya dan saluran irigasi terlokalisasi.',
               'estimated_funding_needed' => 150000000,
               'current_pooled_funds' => 0,
               'financial_tier' => 2,
               'status' => 'pending', // Waiting for Admin to trigger
          ]);

          // 6. Provide dummy market info & sentiment
          MarketPrice::create([
               'monitored_area_id' => $area2->id,
               'commodity_name' => 'Beras Medium',
               'price' => 16500.00,
               'variance_percentage' => 15.5,
               'reference_url' => 'https://sp2kp.kemendag.go.id/',
               'created_at' => Carbon::now(),
          ]);

          SentimentSignal::create([
               'monitored_area_id' => $area1->id,
               'source_type' => 'Google News RSS',
               'raw_text' => 'Warga merapi mulai resah dengan gempa tremor yang terus meningkat sejak tadi malam.',
               'calculated_sentiment' => -0.85,
               'source_link' => 'https://news.google.com/',
               'created_at' => Carbon::now(),
          ]);
     }
}
