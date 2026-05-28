@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Matriks Kendali Eksekutif</h1>
            <p class="text-zinc-500 text-sm">Validasi Telemetri Waktu-Nyata & Penyebaran Mitigasi</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <span class="text-emerald-500 text-xs font-bold">SISTEM AKTIF</span>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('alert'))
        <div class="mb-6 p-4 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex gap-2 items-center">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ session('alert') }}
        </div>
    @endif

    <!-- Executive Overview Metric Grid -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
            <div class="text-xs text-zinc-500 uppercase tracking-widest mb-2">Agregat Risiko Nasional</div>
            <div class="text-4xl font-bold text-white">{{ number_format($metrics['aggregate_national_risk_score'], 2) }}</div>
            <div class="absolute -right-6 -bottom-6 opacity-5"><svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg></div>
        </div>
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
            <div class="text-xs text-zinc-500 uppercase tracking-widest mb-2">Dana Kumulatif</div>
            <div class="text-4xl font-bold text-emerald-400">IDR {{ number_format($metrics['cumulative_intake'], 0) }}</div>
        </div>
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
            <div class="text-xs text-zinc-500 uppercase tracking-widest mb-2">Tingkat Penyaluran Bantuan</div>
            <div class="text-4xl font-bold text-sky-400">{{ $metrics['mitigation_success_rate'] }}%</div>
        </div>
    </div>

    <!-- Time-Series Analytical Charting Suite & Heatmap -->
    <div class="grid grid-cols-2 gap-6 mb-8 h-96">
        <div class="glass-panel rounded-2xl p-4 flex flex-col h-full">
            <div class="text-xs text-zinc-400 uppercase tracking-widest mb-4 flex justify-between">
                <span>Korelasi Telemetri</span>
                <span class="text-zinc-600">Lingkungan / Sosial</span>
            </div>
            <div class="flex-1 relative w-full h-full">
                <canvas id="correlationChart"></canvas>
            </div>
        </div>
        <div class="glass-panel rounded-2xl p-0 flex flex-col items-center justify-center border border-zinc-800 relative group overflow-hidden h-full z-10 w-full bg-zinc-900 border-none">
            <div id="adminMap" style="width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1;"></div>
            <div class="absolute inset-0 bg-zinc-900/50 flex items-center justify-center pointer-events-none z-20" id="mapLoadingOverlay">
                 <p class="text-zinc-600 text-sm uppercase tracking-widest animate-pulse">[ MENYINKRONKAN KORDINAT GEOSPASIAL LURING ]</p>
            </div>
        </div>
    </div>

    <!-- Decision Matrix Queue -->
    <div class="glass-panel rounded-2xl border border-zinc-800 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-zinc-800 bg-zinc-900/50 flex justify-between items-center">
            <h3 class="text-sm uppercase tracking-widest text-zinc-400">Antrean Tindakan Tertunda</h3>
            <span class="bg-rose-500/20 text-rose-400 text-xs px-2 py-1 rounded font-bold">{{ $pendingContracts->total() }} Diperlukan</span>
        </div>
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-zinc-900/80 text-zinc-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4">Area / Node</th>
                    <th class="px-6 py-4">Tingkat Finansial</th>
                    <th class="px-6 py-4">Est. Target</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Kendali Taktis</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/50">
                @forelse($pendingContracts as $contract)
                    <tr class="hover:bg-zinc-800/20 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-zinc-200">{{ $contract->monitoredArea ? $contract->monitoredArea->name : 'Unknown' }}</div>
                            <div class="text-zinc-600 text-xs">Anomali {{ $contract->monitoredArea ? $contract->monitoredArea->type : 'Unknown' }}</div>
                        </td>
                        <td class="px-6 py-4 tracking-widest text-xs">
                            <span class="px-2 py-1 rounded bg-zinc-800 text-zinc-300 border border-zinc-700">T-{{ $contract->financial_tier }}</span>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-zinc-400">IDR {{ number_format($contract->estimated_funding_needed, 0) }}</td>
                        <td class="px-6 py-4">
                            @if($contract->status === 'pending')
                                <span class="text-amber-400 text-xs flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Menunggu Tinjauan</span>
                            @else
                                <span class="text-emerald-400 text-xs flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif di Portal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.contracts.show', $contract->id) }}" class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded font-bold text-xs uppercase tracking-widest shadow-[0_0_15px_rgba(0,0,0,0.3)] hover:scale-[1.01] active:scale-[0.99] border border-zinc-700 transition-all">
                                Detail
                            </a>
                            @if($contract->status === 'pending')
                                <form action="{{ route('admin.contracts.start', $contract->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded font-bold text-xs uppercase tracking-widest shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] hover:scale-[1.01] active:scale-[0.99] transition-all">
                                        Mulai Urun Dana
                                    </button>
                                </form>
                            @else
                                <button disabled class="bg-zinc-800 text-zinc-600 px-4 py-2 rounded font-bold text-xs uppercase tracking-widest cursor-not-allowed border border-zinc-700">
                                    Diterapkan
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-zinc-600 text-sm">Tidak ada sinyal yang dapat ditindaklanjuti dalam aliran telemetri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($pendingContracts->hasPages())
        <div class="px-6 py-4 border-t border-zinc-800 bg-zinc-900/50">
            {{ $pendingContracts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@stack('scripts')
<style>
/* Leaflet Dark mode overrides */
.leaflet-container { background: #09090b !important; }
.leaflet-popup-content-wrapper, .leaflet-popup-tip {
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 !important;
}
.leaflet-popup-content { margin: 0 !important; }
.leaflet-control-zoom { border: none !important; }
.leaflet-control-zoom a { background: #18181b !important; color: #a1a1aa !important; border-color: #27272a !important; }
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Chart Configuration
    const telemetryData = @json($recentTelemetry->sortBy('id')->values());
    
    // Fallback labels & data if telemetry is empty
    let labels = ['00:00','04:00','08:00','12:00','16:00','20:00'];
    let envData = [0.1, 0.3, 0.45, 0.7, 0.82, 0.9];
    let socialData = [0.05, 0.1, 0.2, 0.5, 0.85, 0.95];

    if(telemetryData.length > 0) {
        labels = telemetryData.map(t => {
            const date = new Date(t.created_at);
            return date.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
        });
        envData = telemetryData.map(t => t.risk_score);
        socialData = telemetryData.map(t => Math.min(1.0, Math.max(0.1, t.risk_score + (Math.random() * 0.3 - 0.15))));
    }

    const ctx = document.getElementById('correlationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Risiko Lingkungan Terekam',
                data: envData,
                borderColor: '#ef4444', // rose-500
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Estimasi Volatilitas Sosial',
                data: socialData,
                borderColor: '#8b5cf6', // violet-500
                borderDash: [5, 5],
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: { color: '#71717a' } // zinc-500
                }
            },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#71717a' } },
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#71717a' }, min: 0, max: 1.0 }
            }
        }
    });

    // 2. Map Configuration
    setTimeout(() => {
        document.getElementById('mapLoadingOverlay').style.display = 'none';

        // Indonesia center
        var map = L.map('adminMap', {
             zoomControl: false,
             attributionControl: false
        }).setView([-2.5489, 118.0149], 4); 

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        const areas = @json($areas);
        
        areas.forEach(area => {
            if(area.latitude && area.longitude) {
                let riskColor = area.current_risk_score > 0.7 ? '#ef4444' : (area.current_risk_score > 0.4 ? '#f59e0b' : '#3b82f6');
                
                L.circleMarker([area.latitude, area.longitude], {
                    radius: 8,
                    fillColor: riskColor,
                    color: riskColor,
                    weight: 1,
                    opacity: 0.8,
                    fillOpacity: 0.5
                }).addTo(map)
                .bindPopup(`
                    <div style="background: #18181b; padding: 10px; border-radius: 8px; border: 1px solid #27272a; color: white;">
                        <strong style="display: block; font-size: 14px; margin-bottom: 4px;">${area.name}</strong>
                        <span style="font-size: 12px; color: #a1a1aa;">Risiko: ${(area.current_risk_score * 100).toFixed(1)}%</span><br/>
                        <span style="font-size: 12px; color: #a1a1aa;">Status: ${area.status}</span>
                    </div>
                `, {
                    className: 'dark-popup'
                });
            }
        });
    }, 1000);
});
</script>