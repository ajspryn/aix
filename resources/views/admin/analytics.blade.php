@extends('admin.layouts.admin')

@section('content')
<div class="px-8 py-8 w-full max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white mb-2">Analitik Tingkat Lanjut & Prediksi</h1>
            <p class="text-zinc-400">Dasbor komprehensif ROI Mitigasi dan Deteksi Derivatif Anomali AIX.</p>
        </div>
        <div class="flex items-center gap-3">
             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                  Matrix Aktif (Derivatif 12 Lapis)
             </span>
        </div>
    </div>

    <!-- Impact & Financial ROI Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass-panel p-6 rounded-xl">
             <div class="text-zinc-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Mitigasi Berhasil</div>
             <div class="text-3xl font-light text-white">{{ $totalMitigated }} <span class="text-sm text-zinc-500">Node</span></div>
        </div>
        <div class="glass-panel p-6 rounded-xl">
             <div class="text-zinc-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Mitigasi Gagal (Failed)</div>
             <div class="text-3xl font-light text-rose-500">{{ $totalFailed }} <span class="text-sm text-zinc-500">Node</span></div>
        </div>
        <div class="glass-panel p-6 rounded-xl relative overflow-hidden">
             <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
             <div class="text-zinc-400 text-xs font-semibold uppercase tracking-wider mb-2">Potensi Kerugian Dihindari</div>
             <div class="text-3xl font-light text-emerald-400">Rp {{ number_format($estimatedLossSaved, 0, ',', '.') }}</div>
        </div>
        <div class="glass-panel p-6 rounded-xl">
             <div class="text-zinc-400 text-xs font-semibold uppercase tracking-wider mb-2">Total Dana Donasi Dicairkan</div>
             <div class="text-3xl font-light text-white">Rp {{ number_format($realPooledFunds, 0, ',', '.') }}</div>
             <div class="text-xs text-emerald-500 mt-2">
                 ROI: {{ $realPooledFunds > 0 ? number_format(($estimatedLossSaved / $realPooledFunds), 2, ',', '.') : 0 }}x Margin
             </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
         <!-- Time Series Telemetry Mock -->
         <div class="lg:col-span-2 glass-panel p-6 rounded-xl">
              <h3 class="text-sm font-semibold text-white tracking-widest uppercase mb-6 flex justify-between items-center">
                  Tren Ekstrapolasi Lingkungan (10 Siklus Terakhir)
              </h3>
              <div class="w-full h-72">
                   <canvas id="telemetryChart"></canvas>
              </div>
         </div>

         <!-- Active Critical Nodes Based on AI -->
         <div class="glass-panel p-6 rounded-xl flex flex-col">
              <h3 class="text-sm font-semibold text-white tracking-widest uppercase mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                  Titik Anomali Tinggi
              </h3>
              
              <div class="flex-1 overflow-y-auto pr-2 space-y-3">
                   @forelse($criticalAreas as $area)
                   <div class="bg-zinc-900/50 border border-zinc-800 rounded-lg p-3">
                        <div class="flex justify-between items-center mb-1">
                             <div class="font-medium text-zinc-300 text-sm">{{ $area->name }}</div>
                             <div class="text-xs font-mono {{ $area->current_risk_score > 0.8 ? 'text-rose-500' : 'text-orange-400' }}">
                                  {{ round($area->current_risk_score * 100) }}% RISK
                             </div>
                        </div>
                        <div class="w-full bg-zinc-800 rounded-full h-1.5">
                             <div class="bg-gradient-to-r from-orange-400 to-rose-600 h-1.5 rounded-full" style="width: {{ $area->current_risk_score * 100 }}%"></div>
                        </div>
                        <div class="mt-2 text-[10px] text-zinc-500 font-mono">Deteksi Derivatif Aktif</div>
                   </div>
                   @empty
                   <div class="text-center text-sm text-zinc-600 flex flex-col items-center justify-center h-full gap-2">
                        <svg class="w-8 h-8 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tidak ada titik berisiko kritis saat ini.
                   </div>
                   @endforelse
              </div>
         </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('telemetryChart').getContext('2d');
    
    // Parse pure JSON embedded from blade
    const dates = {!! $dates !!};
    const temps = {!! $temps !!};
    const rains = {!! $rains !!};
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Curah Hujan (mm)',
                    data: rains,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    yAxisID: 'yRain',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Suhu (°C)',
                    data: temps,
                    borderColor: 'rgb(249, 115, 22)',
                    backgroundColor: 'transparent',
                    yAxisID: 'yTemp',
                    tension: 0.4,
                    borderDash: [5, 5]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            color: '#a1a1aa',
            scales: {
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#71717a', font: { family: 'JetBrains Mono' } }
                },
                yRain: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#3b82f6', font: { family: 'JetBrains Mono' } }
                },
                yTemp: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#f97316', font: { family: 'JetBrains Mono' } }
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#a1a1aa', font: { family: 'JetBrains Mono', size: 11 } }
                }
            }
        }
    });
});
</script>
@endpush
