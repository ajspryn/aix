<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelemetryLog extends Model
{
     public $timestamps = false;

     protected $fillable = [
          'monitored_area_id',
          'rainfall_mm',
          'soil_moisture',
          'temperature',
          'raw_payload_json',
          'created_at'
     ];

     protected $casts = [
          'raw_payload_json' => 'array',
          'created_at' => 'datetime'
     ];

     public function monitoredArea(): BelongsTo
     {
          return $this->belongsTo(MonitoredArea::class);
     }
}
