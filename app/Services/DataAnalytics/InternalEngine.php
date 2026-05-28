<?php

declare(strict_types=1);

namespace App\Services\DataAnalytics;

use App\Models\TelemetryLog;
use App\Models\MarketPrice;
use App\Models\SentimentSignal;
use App\Models\ImpactContract;

class InternalEngine
{
    /**
     * Menghitung skor risiko (0.0 - 1.0) dengan mengkombinasikan berbagai sinyal.
     */
    public function computeLiveRiskScore(int $monitoredAreaId): float
    {
        $insight = $this->generateActionableInsight($monitoredAreaId);
        return $insight['risk_score'];
    }

    /**
     * DIAGNOSTIK KELAS ENTERPRISE: Menghasilkan probabilitas, jenis ancaman, dan rekomendasi konkrit
     * Ini menjembatani gap antara "angka algoritma" menjadi "keputusan manusia"
     */
    public function generateActionableInsight(int $monitoredAreaId): array
    {
        $telemetryInsight = $this->analyzeStatisticalTelemetry($monitoredAreaId);
        $priceScore = $this->calculatePriceAnomalyWeight($monitoredAreaId);
        $socialScore = $this->calculateSocialAnxietyWeight($monitoredAreaId);

        $baseRisk = (0.5 * $telemetryInsight['score']) + (0.3 * $priceScore) + (0.2 * $socialScore);

        // Feedback Loop: Resilience Factor
        $historicalMitigations = ImpactContract::where("monitored_area_id", $monitoredAreaId)
               ->whereIn("status", ["funded", "deployed"])
               ->count();

        $resilienceFactor = $historicalMitigations * 0.05; 
        $finalRisk = min(max($baseRisk - $resilienceFactor, 0.0), 1.0);

        // --- INFERENCE ENGINE: Menentukan Ancaman Dominan ---
        $threatDominance = 'Unknown';
        $recommendedAction = 'Monitor lebih lanjut melalui satelit.';
        $worstCase = 'Fluktuasi anomali sistemik yang tidak dapat diprediksi secara lokal.';

        if ($telemetryInsight['dominant_threat'] === 'flood' && $telemetryInsight['score'] > 0.4) {
             $threatDominance = 'Banjir Ekstrem & Tanah Longsor';
             $worstCase = 'Perkiraan curah hujan tinggi ekstrem (' . round($telemetryInsight['max_rain'], 1) . 'mm) menembus standar deviasi (Z-Score tinggi). Wilayah berpotensi tenggelam dan akses logistik terputus total dalam 48 jam.';
             $recommendedAction = 'Distribusi perahu karet portabel, penyedot genangan (water pump diesel), dan pembukaan posko dataran tinggi seketika.';
        } elseif ($telemetryInsight['dominant_threat'] === 'drought' && $telemetryInsight['score'] > 0.4) {
             $threatDominance = 'Kekeringan Suhu Ekstrem';
             $worstCase = 'Lonjakan suhu panas (mencapai ' . round($telemetryInsight['max_temp'], 1) . '°C) dan defisit kelembaban tanah ekstrem. Potensi gagal panen (puso) dan titik api kebakaran meluas.';
             $recommendedAction = 'Drop logistik tandon tangki air (Water Truck), instalasi irigasi tetes sementara, dan pendistribusian benih tahan iklim kering.';
        } elseif ($priceScore > 0.5) {
             $threatDominance = 'Krisis Pangan & Inflasi Area';
             $worstCase = 'Lonjakan harga komoditas lebih dari varians wajar. Daya beli masyarakat miskin hancur, potensi gizi buruk membengkak.';
             $recommendedAction = 'Operasi pasar pasar murah darurat, subsidi tunai langsung (Direct Cash Injection) melalui Escrow, atau penyediaan sembako esensial.';
        }

        // Tweak rekomendasi jika ada riwayat ketahanan
        if ($historicalMitigations > 0 && $finalRisk > 0.6) {
             $recommendedAction = "Evaluasi infrastruktur mitigasi sebelumnya (Area ini sudah pernah dibantu $historicalMitigations kali). Tambahkan skala bantuan atau ubah strategi menjadi relokasi bertahap.";
        }

        return [
            'risk_score' => (float)$finalRisk,
            'confidence' => (float)$telemetryInsight['confidence'], // Berapa % mesin yakin datanya valid
            'threat_type' => $threatDominance,
            'worst_case' => $worstCase,
            'recommendation' => $recommendedAction
        ];
    }

    /**
     * STATISTIK SEJATI (Z-Score, Standard Deviation, Temporal Decay)
     */
    private function analyzeStatisticalTelemetry(int $monitoredAreaId): array
    {
        $logs = TelemetryLog::where('monitored_area_id', $monitoredAreaId)
            ->orderBy('created_at', 'desc')
            ->take(24) // Sampling lebih luas (24 siklus historis)
            ->get();

        if ($logs->count() < 3) {
            return ['score' => 0.0, 'dominant_threat' => 'none', 'confidence' => 0.1, 'max_rain' => 0, 'max_temp' => 0];
        }

        // 1. Array Datapoints
        $rains = $logs->pluck('rainfall_mm')->toArray();
        $temps = $logs->pluck('temperature')->toArray();
        $soils = $logs->pluck('soil_moisture')->toArray();

        // 2. Kalkulasi Mean & Standard Deviation
        $rainMean = $this->mathMean($rains);
        $tempMean = $this->mathMean($temps);
        $rainSd = $this->mathDeviation($rains, $rainMean);
        $tempSd = $this->mathDeviation($temps, $tempMean);

        // 3. Analisis Z-Score pada Data Terbaru (3 Siklus Terakhir vs Seluruh Populasi)
        $recentLogs = $logs->take(3);
        $recentRainAvg = $this->mathMean($recentLogs->pluck('rainfall_mm')->toArray());
        $recentTempAvg = $this->mathMean($recentLogs->pluck('temperature')->toArray());
        
        $rainZScore = $rainSd > 0 ? ($recentRainAvg - $rainMean) / $rainSd : 0;
        $tempZScore = $tempSd > 0 ? ($recentTempAvg - $tempMean) / $tempSd : 0;

        $baseAnomaly = 0.0;
        $threat = 'none';

        // 4. Deteksi Signifikansi Statistik (Z-Score > 1.5 berarti anomali luar biasa)
        if ($rainZScore > 1.5 || $recentRainAvg > 100) {
            $baseAnomaly = min(($rainZScore / 3.0), 1.0); // Normalisasi
            $threat = 'flood';
        } elseif ($tempZScore > 1.5 || $recentTempAvg > 35) {
            $baseAnomaly = min(($tempZScore / 3.0), 1.0);
            $threat = 'drought';
        }

        // 5. Confidence Score (Semakin tinggi variance yang tidak stabil, sistem butuh lebih banyak data, confidence meragukan)
        // Semakin mulus deviasi data, confidence AI makin tinggi.
        $confidence = min(max(1.0 - ($rainSd / 100) - ($tempSd / 50), 0.3), 0.95);

        return [
            'score' => $baseAnomaly,
            'dominant_threat' => $threat,
            'confidence' => $confidence,
            'max_rain' => max($rains),
            'max_temp' => max($temps)
        ];
    }

    private function calculatePriceAnomalyWeight(int $monitoredAreaId): float
    {
        $prices = MarketPrice::where('monitored_area_id', $monitoredAreaId)->orderBy('created_at', 'desc')->take(5)->get();
        if ($prices->isEmpty()) return 0.0;

        $variance = $prices->avg('variance_percentage');
        if ($variance > 50) return 1.0;
        if ($variance > 20) return 0.6;
        if ($variance > 10) return 0.3;
        return 0.1;
    }

    private function calculateSocialAnxietyWeight(int $monitoredAreaId): float
    {
        $signals = SentimentSignal::where('monitored_area_id', $monitoredAreaId)->orderBy('created_at', 'desc')->take(10)->get();
        if ($signals->isEmpty()) return 0.0;
        
        $anxiety = -1.0 * $signals->avg('calculated_sentiment');
        return min(max($anxiety, 0.0), 1.0);
    }

    // --- Utilitas Matematika ---
    private function mathMean(array $arr): float
    {
        if (count($arr) === 0) return 0.0;
        return array_sum($arr) / count($arr);
    }

    private function mathDeviation(array $arr, float $mean): float
    {
        if (count($arr) < 2) return 0.0;
        $variance = 0.0;
        foreach ($arr as $val) {
            $variance += pow($val - $mean, 2);
        }
        return sqrt($variance / (count($arr) - 1));
    }
}
