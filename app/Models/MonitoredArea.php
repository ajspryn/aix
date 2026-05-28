<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoredArea extends Model
{
     protected $fillable = [
          'name',
          'latitude',
          'longitude',
          'current_risk_score',
          'type',
          'base_population',
          'farm_acreage',
          'status',
     ];

     public function telemetryLogs(): HasMany
     {
          return $this->hasMany(TelemetryLog::class);
     }

     public function marketPrices(): HasMany
     {
          return $this->hasMany(MarketPrice::class);
     }

     public function sentimentSignals(): HasMany
     {
          return $this->hasMany(SentimentSignal::class);
     }

     public function attachments(): HasMany
     {
          return $this->hasMany(RiskEvidenceAttachment::class);
     }

     public function contracts(): HasMany
     {
          return $this->hasMany(ImpactContract::class);
     }
}
