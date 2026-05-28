<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrunanContribution extends Model
{
     protected $fillable = [
          'impact_contract_id',
          'user_id',
          'donor_name',
          'amount',
          'payment_status'
     ];

     public function contract(): BelongsTo
     {
          return $this->belongsTo(ImpactContract::class, 'impact_contract_id');
     }
}
