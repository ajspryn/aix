<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentimentSignal extends Model
{
     public $timestamps = false;

     protected $fillable = [
          'monitored_area_id',
          'source_type',
          'raw_text',
          'calculated_sentiment',
          'source_link',
          'created_at'
     ];

     protected $casts = [
          'created_at' => 'datetime'
     ];

     public function monitoredArea(): BelongsTo
     {
          return $this->belongsTo(MonitoredArea::class);
     }
}
