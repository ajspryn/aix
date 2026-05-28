<?php

declare(strict_types=1);

namespace App\Services\Alerting;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SystemAlertService
{
    /**
     * Triggered when ML Engine detects Critical node.
     */
    public static function notifyCriticalZone(string $areaName, float $riskScore): void
    {
        $percentage = number_format($riskScore * 100, 1);
        $message = "🚨 [DARURAT AIX] 🚨\nZona Kritis Terdeteksi: {$areaName}\nSkor Risiko Prediktif: {$percentage}%\nIntervensi AIX dibutuhkan segera.";
        
        self::dispatchWebhook($message);
    }

    /**
     * Triggered when Crowdfunding is fulfilled
     */
    public static function notifyTargetFunded(string $areaName, float $amount): void
    {
        $rp = number_format($amount, 0, ',', '.');
        $message = "✅ [AIX ESCROW] ✅\nKontrak mitigasi untuk {$areaName} TERPENUHI (Rp {$rp}).\nMemulai Fase Post-Mitigasi & Pencairan Dana Eksekutor Lapangan.";
        
        self::dispatchWebhook($message);
    }

    private static function dispatchWebhook(string $message): void
    {
        // 1. Catat ke log sistem internal untuk jejak audit
        Log::channel('daily')->alert("WEBHOOK_OUTBOUND: \n" . $message);

        // 2. Simulasi Webhook Eksternal (contoh ke Telegram / Slack)
        // Di environment production, ganti token dummy ini dengan config('services.telegram.token')
        // Http::timeout(3)->post('https://api.telegram.org/bot<DUMMY_TOKEN>/sendMessage', [
        //    'chat_id' => '<DUMMY_CHAT_ID>',
        //    'text' => $message
        // ]);
    }
}
