@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Detail Antrean Tindakan</h1>
            <p class="text-zinc-500 text-sm">Menampilkan informasi lengkap mengenai anomali dan target pendanaan mitigasi.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded font-bold text-xs uppercase tracking-widest transition-all">
            &larr; Kembali ke Dasbor
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800 lg:col-span-2">
            <h2 class="text-xl font-bold text-white mb-4">Informasi Kontrak</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Area / Node</div>
                    <div class="text-white font-bold">{{ $contract->monitoredArea ? $contract->monitoredArea->name : 'Unknown' }}</div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Tipe Anomali</div>
                    <div class="text-rose-400 font-bold capitalize">{{ $contract->monitoredArea ? $contract->monitoredArea->type : 'Unknown' }}</div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Tingkat Finansial</div>
                    <div class="text-white font-mono">T-{{ $contract->financial_tier }}</div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Target Pendanaan (IDR)</div>
                    <div class="text-emerald-400 font-mono font-bold">Rp {{ number_format($contract->estimated_funding_needed, 0, ',', '.') }}</div>
                </div>
            </div>

            <h3 class="text-zinc-400 text-sm font-bold mb-2 uppercase tracking-widest">Analisis Situasi:</h3>
            <div class="bg-zinc-900/40 p-4 rounded-xl border border-zinc-800 text-zinc-300 text-sm leading-relaxed mb-6">
                {{ $contract->situational_narrative ?? 'Narasi belum tersedia atau area ini belum dievaluasi oleh sistem.' }}
            </div>

            @if($contract->status === 'pending')
            <form action="{{ route('admin.contracts.start', $contract->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-4 rounded-xl font-bold text-sm uppercase tracking-widest shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all flex justify-center items-center gap-2">
                    Mulai Urun Dana Sekarang
                </button>
            </form>
            @endif
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            <h2 class="text-xl font-bold text-white mb-4">Metrik Telemetri (10 Terakhir)</h2>
            <div class="space-y-4">
                @if($contract->monitoredArea)
                    @forelse($contract->monitoredArea->telemetryLogs as $log)
                    <div class="bg-zinc-900/50 p-3 rounded-lg border border-zinc-800">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs text-zinc-500">{{ $log->created_at->format('d M H:i') }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="text-zinc-400">Suhu: <span class="text-white">{{ $log->temperature }}&deg;C</span></div>
                            <div class="text-zinc-400">Hujan: <span class="text-white">{{ $log->rainfall_mm }}mm</span></div>
                            <div class="text-zinc-400">Kelembaban: <span class="text-white">{{ number_format($log->soil_moisture, 2) }}%</span></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-zinc-600 text-sm py-8">
                        Data telemetri belum terekam.
                    </div>
                    @endforelse
                @else
                    <div class="text-center text-zinc-600 text-sm py-8">
                        Tidak ada data Area/Node yang terkait.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="glass-panel p-6 rounded-2xl border border-zinc-800 mb-8">
        <h2 class="text-xl font-bold text-white mb-4">Riwayat Donasi / Kontribusi</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Waktu Kontribusi</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Nama Donatur</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Nominal (IDR)</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($contract->contributions as $trx)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-4 text-zinc-400 font-mono">{{ $trx->created_at->format("Y-m-d H:i:s") }}</td>
                        <td class="py-4 px-4 text-white font-medium">{{ $trx->donor_name ?? "Anonim" }}</td>
                        <td class="py-4 px-4 text-emerald-400 font-bold font-mono">Rp {{ number_format($trx->amount, 0, ",", ".") }}</td>
                        <td class="py-4 px-4">
                            @if($trx->payment_status === "paid" || $trx->payment_status === "settlement" || $trx->payment_status === "success")
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    Berhasil
                                </span>
                            @elseif($trx->payment_status === "pending")
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    Tertunda
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    {{ ucfirst($trx->payment_status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-zinc-500">
                            Belum ada jalur donasi yang tercatat untuk kontrak ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection