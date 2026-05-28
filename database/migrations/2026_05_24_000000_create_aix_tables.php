<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
     {
          Schema::create('users', function (Blueprint $table) {
               $table->id();
               $table->string('name');
               $table->string('email')->unique();
               $table->string('password');
               $table->enum('role', ['admin', 'user'])->default('user');
               $table->timestamps();
          });

          Schema::create('monitored_areas', function (Blueprint $table) {
               $table->id();
               $table->string('name');
               $table->decimal('latitude', 10, 8);
               $table->decimal('longitude', 11, 8);
               $table->float('current_risk_score')->default(0);
               $table->enum('type', ['geological', 'economic', 'agriculture']);
               $table->integer('base_population');
               $table->float('farm_acreage')->nullable();
               $table->enum('status', ['stable', 'warning', 'critical'])->default('stable');
               $table->timestamps();
          });

          Schema::create('telemetry_logs', function (Blueprint $table) {
               $table->id();
               $table->foreignId('monitored_area_id')->constrained()->cascadeOnDelete();
               $table->float('rainfall_mm')->nullable();
               $table->float('soil_moisture')->nullable();
               $table->float('temperature')->nullable();
               $table->json('raw_payload_json');
               $table->timestamp('created_at');
          });

          Schema::create('market_prices', function (Blueprint $table) {
               $table->id();
               $table->foreignId('monitored_area_id')->constrained()->cascadeOnDelete();
               $table->string('commodity_name');
               $table->decimal('price', 15, 2);
               $table->decimal('variance_percentage', 5, 2);
               $table->string('reference_url');
               $table->timestamp('created_at');
          });

          Schema::create('sentiment_signals', function (Blueprint $table) {
               $table->id();
               $table->foreignId('monitored_area_id')->constrained()->cascadeOnDelete();
               $table->string('source_type');
               $table->text('raw_text');
               $table->float('calculated_sentiment');
               $table->string('source_link');
               $table->timestamp('created_at');
          });

          Schema::create('risk_evidence_attachments', function (Blueprint $table) {
               $table->id();
               $table->foreignId('monitored_area_id')->constrained()->cascadeOnDelete();
               $table->enum('file_type', ['satellite_img', 'cctv_snapshot', 'field_photo']);
               $table->string('image_url');
               $table->text('description');
               $table->timestamps();
          });

          Schema::create('impact_contracts', function (Blueprint $table) {
               $table->id();
               $table->foreignId('monitored_area_id')->constrained()->cascadeOnDelete();
               $table->text('worst_case_scenario');
               $table->text('automated_mitigation_plan');
               $table->decimal('estimated_funding_needed', 20, 2);
               $table->decimal('current_pooled_funds', 20, 2)->default(0);
               $table->integer('financial_tier'); // 1, 2, 3
               $table->enum('status', ['pending', 'open', 'funded', 'active_mitigation', 'state_lock']);
               $table->timestamps();
          });

          Schema::create('urunan_contributions', function (Blueprint $table) {
               $table->id();
               $table->foreignId('impact_contract_id')->constrained()->cascadeOnDelete();
               $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
               $table->string('donor_name');
               $table->decimal('amount', 20, 2);
               $table->enum('payment_status', ['success', 'pending', 'failed']);
               $table->timestamps();
          });
     }

     public function down(): void
     {
          Schema::dropIfExists('urunan_contributions');
          Schema::dropIfExists('impact_contracts');
          Schema::dropIfExists('risk_evidence_attachments');
          Schema::dropIfExists('sentiment_signals');
          Schema::dropIfExists('market_prices');
          Schema::dropIfExists('telemetry_logs');
          Schema::dropIfExists('monitored_areas');
          Schema::dropIfExists('users');
     }
};
