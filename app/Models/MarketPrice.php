<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketPrice extends Model
{
     public $timestamps = false;

     protected $fillable = [
          'monitored_area_id',
          'commodity_name',
          'price',
          'variance_percentage',
          'reference_url',
          'created_at',
     ];

     protected $casts = [
          'created_at' => 'datetime'
     ];

     public function monitoredArea(): BelongsTo
     {
          return $this->belongsTo(MonitoredArea::class);
     }
}
