<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImpactContract;
use App\Models\MonitoredArea;
use App\Services\DataAnalytics\RiskExplanationEngine;

class PublicPortalController extends Controller
{
     public function __construct(
          private readonly RiskExplanationEngine $riskExplanationEngine
     ) {}

     public function explore(Request $request)
     {
          $openContracts = ImpactContract::with(['monitoredArea.attachments'])
               ->where('status', 'open') // Apapun skor resikonya, selama kontrak masih open, harus ditampilkan di bawah
               ->get()
               ->map(function ($contract) {
                    $contract->progress_percent = $contract->estimated_funding_needed > 0
                         ? min(100, round(($contract->current_pooled_funds / $contract->estimated_funding_needed) * 100))
                         : 0;
                    return $contract;
               })
               ->sortByDesc(fn($c) => $c->monitoredArea->current_risk_score ?? 0)
               ->values();

          return view('public.explore', [
               'topContracts' => $openContracts->take(3),
               'otherContracts' => $openContracts->skip(3)->values(),
               'openContracts' => $openContracts
          ]);
     }

     public function showContract($id)
     {
          $contract = ImpactContract::with(['monitoredArea.attachments', 'monitoredArea.telemetryLogs'])
               ->findOrFail($id);

          $contract->narrative = $this->riskExplanationEngine->generateHumanNarrative($contract->monitoredArea, $contract);

          $contract->progress_percent = $contract->estimated_funding_needed > 0
               ? min(100, round(($contract->current_pooled_funds / $contract->estimated_funding_needed) * 100))
               : 0;

          $sentimentSignals = \App\Models\SentimentSignal::where('monitored_area_id', $contract->monitored_area_id)
               ->latest()
               ->paginate(5);

          return view('public.contract', [
               'contract' => $contract,
               'sentimentSignals' => $sentimentSignals
          ]);
     }


     public function donate(Request $request, $id)
     {
          $request->validate([
               "amount" => "required|numeric|min:10000",
          ]);

          $contract = ImpactContract::findOrFail($id);

          if (!in_array($contract->status, ["open", "pending"])) {
               return redirect()->back()->with("error_donation", "Penerimaan dana untuk kontrak ini sudah ditutup.");
          }

          \Midtrans\Config::$serverKey = config("midtrans.serverKey");
          \Midtrans\Config::$isProduction = config("midtrans.isProduction");
          \Midtrans\Config::$isSanitized = config("midtrans.isSanitized");
          \Midtrans\Config::$is3ds = config("midtrans.is3ds");

          $orderId = "AIX-DON-" . $contract->id . "-" . time();

          $params = [
               "transaction_details" => [
                    "order_id" => $orderId,
                    "gross_amount" => (int) $request->amount,
               ],
               "customer_details" => [
                    "first_name" => "Donatur",
                    "last_name" => "AIX",
                    "email" => "donatur@aix.gov",
                    "phone" => "081234567890",
               ],
               "item_details" => [
                    [
                         "id" => "CONTRACT-" . $contract->id,
                         "price" => (int) $request->amount,
                         "quantity" => 1,
                         "name" => "Mitigasi Bencana: " . $contract->monitoredArea->name,
                    ]
               ]
          ];

          try {
               $snapToken = \Midtrans\Snap::getSnapToken($params);
               session()->put("pending_donation_amount", $request->amount);
               session()->put("snap_token", $snapToken);
               return redirect()->back();
          } catch (\Exception $e) {
               return redirect()->back()->with("error_donation", "Gagal memproses pembayaran: " . $e->getMessage());
          }
     }

     public function paymentSuccess(Request $request, $id)
     {
          $contract = ImpactContract::findOrFail($id);
          $amount = session()->pull("pending_donation_amount", 0);

          if ($amount > 0) {
               $contract->current_pooled_funds += $amount;
               if ($contract->current_pooled_funds >= $contract->estimated_funding_needed && $contract->status == "open") {
                    $contract->status = "funded";
                    // TRANSAKSI TERPENUHI: PICU NOTIFIKASI ESCROW KE VENDOR/ADMIN
                    \App\Services\Alerting\SystemAlertService::notifyTargetFunded($contract->monitoredArea->name ?? "Unknown Area", (float)$contract->current_pooled_funds);
               }
               $contract->save();
          }

          return redirect()->route("public.contract.show", $id)->with("success_donation", "Validasi Smart Contract berhasil. Anda telah berkontribusi sebesar IDR " . number_format((float)$amount, 0) . " untuk misi penyelamatan ini.");
     }

}
