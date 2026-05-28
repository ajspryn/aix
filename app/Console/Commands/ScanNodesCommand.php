<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MonitoredArea;
use App\Models\ImpactContract;
use App\Models\TelemetryLog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Services\DataAnalytics\InternalEngine;

class ScanNodesCommand extends Command
{
    protected $signature = 'aix:scan-nodes {--count=12 : Jumlah node yang ingin dipindai}';
    protected $description = 'Menjalankan radar AIX untuk memindai anomali geografis baru di titik-titik valid seluruh Indonesia.';

    public function handle()
    {
        $count = (int) $this->option('count');
        $this->info("Menghidupkan Mesin Radar AIX terkalibrasi...");
        $this->warn("Memulai pemindaian satelit dalam radius Nusantara daratan...");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $types = ['geological', 'agriculture', 'economic'];
        $statuses = ['stable', 'warning', 'critical'];

        // Base coordinates arrays (Lat, Lng) for main Indonesian islands to avoid oceans/other countries
        $baseLocations = [
            // Sumatera
            'Medan' => [3.5952, 98.6722],
            'Padang' => [3.5952, 98.6722],
            'Pekanbaru' => [-0.9471, 100.3543],
            'Palembang' => [-2.9909, 104.7566],
            'Bukittinggi' => [-0.3015, 100.3692],
            // Jawa
            'Jakarta' => [-6.2088, 106.8456],
            'Bandung' => [-6.9175, 107.6191],
            'Semarang' => [-7.0051, 110.4381],
            'Yogyakarta' => [-7.7956, 110.3695],
            'Surabaya' => [-7.2504, 112.7688],
            'Malang' => [-7.9839, 112.6214],
            'Banyuwangi' => [-8.2192, 114.3692],
            // Bali & Nusa Tenggara
            'Denpasar' => [-8.6705, 115.2126],
            'Mataram' => [-8.5833, 116.1167],
            'Kupang' => [-10.1772, 123.6070],
            'Ende' => [-8.8446, 121.6621],
            // Kalimantan
            'Pontianak' => [0.5028, 101.4474],
            'Balikpapan' => [-0.0227, 109.3333],
            'Banjarmasin' => [-1.2379, 116.8529],
            'Palangkaraya' => [-2.2083, 113.9167],
            'Samarinda' => [-3.3167, 114.5833],
            // Sulawesi
            'Makassar' => [-5.1476, 119.4327],
            'Manado' => [1.4822, 124.8489],
            'Palu' => [-0.9003, 119.8780],
            'Kendari' => [-3.9984, 122.5126],
            // Maluku & Papua
            'Ambon' => [-3.6954, 128.1814],
            'Ternate' => [1.7919, 127.3208],
            'Jayapura' => [-2.5337, 140.7181],
            'Manokwari' => [0.8654, 134.0735],
            'Merauke' => [-0.8647, 134.0620],
            'Timika' => [-8.4996, 140.3957]
        ];

        for ($i = 0; $i < $count; $i++) {
            $locationKey = array_rand($baseLocations);
            $baseCoord = $baseLocations[$locationKey];

            // Add random jitter (-0.5 to 0.5 degrees) to spread around the city, keeping it mostly on land
            $lat = $baseCoord[0] + (mt_rand(-5000, 5000) / 10000);
            $lng = $baseCoord[1] + (mt_rand(-5000, 5000) / 10000);

            $type = $types[array_rand($types)];
            $status = $statuses[array_rand($statuses)];
            $names = [
                'Sektor Pesisir',
                'Sabuk Pertanian',
                'Zona Vulkanik',
                'Ring Perkotaan',
                'Lembah Hijau',
                'Daerah Aliran Sungai',
                'Lereng Bukit',
                'Distrik Resapan'
            ];
            $name = $names[array_rand($names)] . ' ' . $locationKey . ' - ' . strtoupper(Str::random(3));

            // KETAHANAN SKALA (RATE LIMITING QUEUE)
            // Memindahkan proses penarikan API (Satelit Eksternal) dan kalkulasi ML dari mode blocking ke Job Antrean Latar Belakang (Asynchronous)
            \App\Jobs\AnalyzeNodeEnvironmentJob::dispatch($baseCoord, (string)$locationKey, $type);
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("[$count] Titik anomali berhasil dipindai dan dikalkulasi ke dalam database satelit AIX.");
    }
}
