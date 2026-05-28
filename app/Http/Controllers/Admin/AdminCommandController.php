<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImpactContract;
use App\Models\TelemetryLog;
use App\Models\MonitoredArea;
use App\Models\UrunanContribution;
use App\Services\DataAnalytics\InternalEngine;

class AdminCommandController extends Controller
{
     public function __construct(
          private readonly InternalEngine $internalEngine
     ) {}

     public function index(Request $request)
     {
          $areas = MonitoredArea::with(['contracts' => function ($q) {
               $q->whereIn('status', ['pending', 'open']);
          }])->get();

          $recentTelemetry = TelemetryLog::with('monitoredArea')->latest()->take(20)->get();

          $totalContracts = ImpactContract::count();
          $deployedContracts = ImpactContract::where('status', 'deployed')->count();
          $successRate = $totalContracts > 0 ? ($deployedContracts / $totalContracts) * 100 : 0;

          $metrics = [
               'aggregate_national_risk_score' => $areas->avg('current_risk_score') ?? 0,
               'cumulative_intake' => ImpactContract::whereIn('status', ['funded', 'deployed'])->sum('current_pooled_funds'),
               'mitigation_success_rate' => round($successRate, 1)
          ];

          $pendingContracts = ImpactContract::with('monitoredArea')
               ->whereIn('status', ['pending', 'open'])
               ->orderBy('created_at', 'desc')
               ->paginate(10);

          return view('admin.dashboard', [
               'areas' => $areas,
               'recentTelemetry' => $recentTelemetry,
               'metrics' => $metrics,
               'pendingContracts' => $pendingContracts
          ]);
     }

     public function showContract(Request $request, int $id)
     {
          $contract = ImpactContract::with([
               'monitoredArea.telemetryLogs' => function ($q) {
                    $q->latest()->take(10);
               },
               'contributions' => function ($q) {
                    $q->latest();
               }
          ])->findOrFail($id);

          return view('admin.contract_detail', compact('contract'));
     }

     public function telemetryLogs(Request $request)
     {
          $logs = TelemetryLog::with('monitoredArea')
               ->orderBy('created_at', 'desc')
               ->paginate(30);

          return view('admin.telemetry', compact('logs'));
     }

     public function donations(Request $request)
     {
          $contributions = UrunanContribution::with(['contract.monitoredArea'])
               ->orderBy('created_at', 'desc')
               ->paginate(30);

          return view('admin.donations', compact('contributions'));
     }

     public function startCrowdfunding(Request $request, int $id)
     {
          $contract = ImpactContract::findOrFail($id);

          if ($contract->status !== 'pending') {
               return redirect()->back()->with('error', 'Only pending contracts can be opened.');
          }

          if ($contract->financial_tier === 3) {
               $contract->update(['status' => 'state_lock']);
               return redirect()->back()->with('alert', 'State Intervention Required. Crowdfunding is locked.');
          }

          $contract->update(['status' => 'open']);
          return redirect()->back()->with('success', 'Crowdfunding successfully opened to the public portal.');
     }

     public function analyticsDashboard(Request $request)
     {
          // DATA UNTUK MESIN PREDIKSI DAN ANALITIK TINGKAT LANJUT
          $totalMitigated = ImpactContract::whereIn('status', ['funded', 'deployed'])->count();
          $totalFailed = ImpactContract::whereIn('status', ['failed'])->count();
          
          $estimatedLossSaved = ImpactContract::whereIn('status', ['funded', 'deployed'])->sum('estimated_funding_needed');
          $realPooledFunds = ImpactContract::whereIn('status', ['funded', 'deployed'])->sum('current_pooled_funds');

          // Top 10 High Risk Areas that need immediate attention
          $criticalAreas = MonitoredArea::where('current_risk_score', '>=', 0.5)
               ->orderBy('current_risk_score', 'desc')
               ->take(10)
               ->get();

          // Time Series untuk Chart (Mock dari Telemetry 10 Hari terakhir)
          $telemetryData = TelemetryLog::selectRaw('DATE(created_at) as date, AVG(temperature) as avg_temp, AVG(rainfall_mm) as avg_rain')
               ->groupBy('date')
               ->orderBy('date', 'asc')
               ->take(10)
               ->get();

          $dates = $telemetryData->pluck('date')->toJson();
          $temps = $telemetryData->pluck('avg_temp')->toJson();
          $rains = $telemetryData->pluck('avg_rain')->toJson();

          return view('admin.analytics', compact(
               'totalMitigated',
               'totalFailed',
               'estimatedLossSaved',
               'realPooledFunds',
               'criticalAreas',
               'dates',
               'temps',
               'rains'
          ));
     }
}
