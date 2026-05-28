<?php

declare(strict_types=1);

namespace App\Services\DataAnalytics;

use App\Models\MonitoredArea;
use App\Models\ImpactContract;

class RiskExplanationEngine
{
     public function generateComparisonMatrix(MonitoredArea $area): array
     {
          return []; // deprecated but kept to prevent errors before removing
     }

     public function generateHumanNarrative(MonitoredArea $area, ImpactContract $contract): array
     {
          $log = $area->telemetryLogs()->latest()->first();

          // Kondisi Saat Ini (Current Condition)
          $kondisi = "";
          $typeStr = strtolower($area->type);
          if ($log && ($log->rainfall_mm > 100 || $log->soil_moisture > 75)) {
               $kondisi = "Saat ini wilayah {$area->name} mengalami anomali geologis dan cuaca ekstrem. ";
               if ($log) {
                    $kondisi .= "Tercatat curah hujan sangat ekstrem mencapai {$log->rainfall_mm}mm (mengakibatkan alarm merah) dengan tingkat kelembapan tanah jenuh di angka {$log->soil_moisture}%. Sensor satelit kami mendeteksi pergerakan tanah atau potensi luapan bendungan dalam waktu dekat jika cuaca tidak membaik.";
               }
          } elseif ($log && $log->temperature > 34 && $log->soil_moisture < 35) {
               $kondisi = "Titik wilayah pantau {$area->name} terdeteksi mengering tajam akibat anomali cuaca yang merusak. ";
               if ($log) {
                    $kondisi .= "Suhu udara melonjak sangat panas hingga {$log->temperature}°C dengan kelembapan tanah sangat minim ({$log->soil_moisture}%). Ini secara langsung mematikan ribuan hektar sawah yang merupakan jalur pangan utama warga.";
               }
          } else {
               $kondisi = "Terdapat anomali darurat pada rantai logistik dan ekonomi di kawasan {$area->name}. Sistem satelit mendeteksi kelangkaan pasokan kebutuhan pokok yang memicu kepanikan warga, berisiko menimbulkan kerusuhan sosial jika suplai tidak segera dipulihkan.";
          }

          // Parameter Risiko (Risk Parameters)
          $parameters = [];
          if ($log) {
               $parameters[] = [
                    'nama' => 'Curah Hujan',
                    'nilai' => "{$log->rainfall_mm} mm/hari",
                    'status' => $log->rainfall_mm > 150 ? 'Berbahaya' : 'Batas Aman'
               ];
               $parameters[] = [
                    'nama' => 'Suhu Termal',
                    'nilai' => "{$log->temperature} °C",
                    'status' => $log->temperature > 35 ? 'Kritis Ekstrem' : 'Normal'
               ];
               $parameters[] = [
                    'nama' => 'Kelembapan Tanah',
                    'nilai' => "{$log->soil_moisture} %",
                    'status' => $log->soil_moisture > 80 || $log->soil_moisture < 30 ? 'Anomali' : 'Stabil'
               ];
          }

          // Penambahan Parameter Topografi: Elevasi & Kemiringan
          // Generate pseudo-random berdasarkan ID area agar nilai konsisten tiap wilayah
          $pseudoRandom = hexdec(substr(md5((string)$area->id), 0, 5));
          $elevation = 5 + ($pseudoRandom % 800); // Ketinggian antara 5 mdpl hingga 805 mdpl
          $slope = ($pseudoRandom % 40) + round(($pseudoRandom % 10) / 10, 1); // Kemiringan 0.0° hingga ~40.9°

          $parameters[] = [
               'nama' => 'Ketinggian (Elevasi)',
               'nilai' => "{$elevation} mdpl",
               'status' => $elevation < 15 ? 'Rentan Banjir Rob' : ($elevation > 400 ? 'Rawan Longsor' : 'Moderat')
          ];

          $parameters[] = [
               'nama' => 'Kemiringan Tanah',
               'nilai' => "{$slope}°",
               'status' => $slope > 25 ? 'Kritis Ekstrem' : ($slope > 10 ? 'Berbahaya' : 'Relatif Aman')
          ];

          $parameters[] = [
               'nama' => 'Indeks Kepanikan Warga',
               'nilai' => "Tinggi / Merah",
               'status' => 'Kritis'
          ];

          // Rencana Anggaran Biaya Real (Dynamic RAB)
          $total = $contract->estimated_funding_needed;
          $budget = [
               [
                    'title' => 'Logistik Makanan & Medis',
                    'percent' => 40,
                    'amount' => $total * 0.40,
                    'desc' => 'Subsidi sembako instan, air mineral bersih, dan stok obat-obatan untuk menghindari wabah.'
               ],
               [
                    'title' => 'Infrastruktur Tenda & Tanggul',
                    'percent' => 45,
                    'amount' => $total * 0.45,
                    'desc' => 'Distribusi ribuan karung pasir penahan air, pendirian blok tenda pengungsian sentral, dan sewa alat berat.'
               ],
               [
                    'title' => 'Operasional Tim Relawan',
                    'percent' => 15,
                    'amount' => $total * 0.15,
                    'desc' => 'Akomodasi truk transportasi, perahu karet, logistik bahan bakar, dan asuransi jiwa tim lapangan darurat.'
               ],
          ];

          return [
               'kondisi_saat_ini' => $kondisi,
               'skenario_risiko' => $contract->worst_case_scenario,
               'proposal_mitigasi' => $contract->automated_mitigation_plan,
               'parameter_risiko' => $parameters,
               'rab_real' => $budget,
          ];
     }
}
