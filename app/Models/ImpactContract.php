<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpactContract extends Model
{
     protected $fillable = [
          'monitored_area_id',
          'worst_case_scenario',
          'automated_mitigation_plan',
          'estimated_funding_needed',
          'current_pooled_funds',
          'financial_tier',
          'status'
     ];

     public function monitoredArea(): BelongsTo
     {
          return $this->belongsTo(MonitoredArea::class);
     }

     public function contributions()
     {
          return $this->hasMany(UrunanContribution::class);
     }
}
