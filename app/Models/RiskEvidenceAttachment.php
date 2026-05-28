<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskEvidenceAttachment extends Model
{
     protected $fillable = [
          'monitored_area_id',
          'file_type',
          'image_url',
          'description',
     ];

     public function monitoredArea(): BelongsTo
     {
          return $this->belongsTo(MonitoredArea::class);
     }
}
