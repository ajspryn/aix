<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ImpactContract;
use App\Models\UrunanContribution;
use Illuminate\Http\JsonResponse;

class PaymentWebhookController extends Controller
{
     public function __invoke(Request $request): JsonResponse
     {
          // Simulate Google Pay webhook request payload
          // Expected payload: { "contract_id": 1, "donor_name": "John Doe", "amount": 500000, "status": "success", "transaction_id": "GPay-12345" }

          $validated = $request->validate([
               'contract_id' => 'required|integer|exists:impact_contracts,id',
               'donor_name' => 'required|string|max:255',
               'amount' => 'required|numeric|min:1',
               'status' => 'required|string|in:success,failed,pending',
          ]);

          if ($validated['status'] !== 'success') {
               return response()->json(['message' => 'Ignored, payment not successful'], 200);
          }

          try {
               DB::transaction(function () use ($validated) {
                    $contract = ImpactContract::lockForUpdate()->findOrFail($validated['contract_id']);

                    if (in_array($contract->status, ['funded', 'active_mitigation', 'state_lock'])) {
                         throw new \Exception('Contract is no longer accepting funds.');
                    }

                    $contribution = new UrunanContribution();
                    $contribution->impact_contract_id = $contract->id;
                    $contribution->donor_name = $validated['donor_name'];
                    $contribution->amount = $validated['amount'];
                    $contribution->payment_status = 'success';
                    $contribution->save();

                    $contract->current_pooled_funds += $validated['amount'];

                    if ($contract->current_pooled_funds >= $contract->estimated_funding_needed) {
                         $contract->status = 'funded';
                    }

                    $contract->save();
               });

               return response()->json(['message' => 'Processed successfully'], 200);
          } catch (\Exception $e) {
               return response()->json(['error' => $e->getMessage()], 422);
          }
     }
}
