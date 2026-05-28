<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImpactContract;
use App\Models\TelemetryLog;
use App\Models\MonitoredArea;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TrackPostMitigationImpact extends Command
{
    protected $signature = 'aix:track-impact';
    protected $description = 'Mengevaluasi kontrak yang sudah Fund atau Deployed dan mensimulasikan metrik pasca-mitigasi untuk mesin pelacakan dampak ROI.';

    public function handle()
    {
        $this->info("Menjalankan Evaluasi Pasca-Mitigasi...");

        // Cari kontrak yang dananya terpenuhi (funded).
        // Kita ubah otomatis menjadi "deployed" untuk disimulasikan bahwa bantuan telah turun ke lapangan
        $fundedContracts = ImpactContract::where('status', 'funded')->get();
        foreach ($fundedContracts as $contract) {
            $contract->update(['status' => 'deployed']);
            $this->info("Kontrak #{$contract->id} kini DEPLOYED: Bantuan teknis & operasional telah dikirimkan ke lokasi.");
        }

        // Cari area-area yang sedang dalam mitigasi ("deployed")
        $deployedAreaIds = ImpactContract::where('status', 'deployed')->pluck('monitored_area_id')->toArray();
        $mitigatedAreas = MonitoredArea::whereIn('id', $deployedAreaIds)->get();

        if ($mitigatedAreas->isEmpty()) {
            $this->info("Tidak ada area yang sedang dalam fase Post-Mitigation eksekusi.");
            return;
        }

        foreach ($mitigatedAreas as $area) {
            // Karena intervensi telah dilakukan, suhu dan kelembaban (dan situasi lapangan) berangsur membaik.
            // Kami menyuntikkan telemetri "Penyembuhan" buatan (Hanya sebagai simulasi sistem Pelacakan Dampak/ROI)
            TelemetryLog::create([
                'monitored_area_id' => $area->id,
                'rainfall_mm' => mt_rand(40, 60), // Hujan normal kembali
                'soil_moisture' => mt_rand(50, 70), // Tanah terhidrasi (mungkin akibat pompa air donasi)
                'temperature' => mt_rand(26, 30), // Suhu mereda
                'raw_payload_json' => ['sensor_ping' => 'POST-MITIGATION-RECOVERY', 'recovery_status' => 'active'],
                'created_at' => Carbon::now(),
            ]);

            // Menurunkan status resiko area secara drastis sebagai fungsi penyembuhan
            $area->update([
                'current_risk_score' => 0.15,
                'status' => 'stable'
            ]);

            $this->line("Telemetri penyembuhan (Post-Mitigation) dipompa ke Area: {$area->name}");
        }

        $this->info("AIX Impact Pelacakan selesai.");
    }
}
