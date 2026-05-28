<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentWebhookController;
use App\Models\MonitoredArea;

// Google Pay transaction engine via webhook
Route::post('/payment-webhook', PaymentWebhookController::class)->name('api.payment.webhook');

// Geospatial Risk Map GeoJSON 
Route::get('/geojson-risks', function () {
     $areas = MonitoredArea::with(['contracts' => function ($q) {
          $q->latest()->limit(1);
     }])
          ->where(function ($query) {
               $query->where('current_risk_score', '>=', 0.2) // Tampilkan jika resiko di atas 0.2
                    ->orWhereHas('contracts', function ($q) {
                         $q->where('status', 'open'); // Atau jika memiliki kontrak donasi yang masih berjalan
                    });
          })
          ->orderByDesc('current_risk_score')
          ->limit(50)
          ->get();

     $features = $areas->map(function ($area) {
          $contract = $area->contracts->first();
          return [
               'type' => 'Feature',
               'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float)$area->longitude, (float)$area->latitude],
               ],
               'properties' => [
                    'id' => $area->id,
                    'name' => $area->name,
                    'status' => $area->status,
                    'risk_score' => $area->current_risk_score,
                    'type' => match ($area->type) {
                         'geological' => 'Geologis',
                         'agriculture' => 'Agrikultur',
                         'economic' => 'Ekonomi',
                         default => $area->type
                    },
                    'last_updated' => $area->updated_at->diffForHumans(),
                    'contract_id' => $contract ? $contract->id : null,
                    'target_funds' => $contract ? $contract->estimated_funding_needed : rand(50000000, 500000000),
                    'severity_level' => $area->current_risk_score > 0.8 ? 'Kritis' : ($area->current_risk_score > 0.5 ? 'Menengah' : 'Stabil')
               ]
          ];
     });

     return response()->json([
          'type' => 'FeatureCollection',
          'features' => $features
     ]);
});
