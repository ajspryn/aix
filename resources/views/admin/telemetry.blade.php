@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Log Telemetri Global</h1>
            <p class="text-zinc-500 text-sm">Transmisi data waktu-nyata dari semua node lapangan</p>
        </div>
    </header>

    <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Waktu (WIB)</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Node / Area</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Suhu</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Curah Hujan</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Kelembaban</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Status Data</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($logs as $log)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-4 text-zinc-400 font-mono">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="py-4 px-4 text-white font-medium">{{ $log->monitoredArea ? $log->monitoredArea->name : 'Node Tidak Dikenal' }}</td>
                        <td class="py-4 px-4">
                            <span class="{{ $log->temperature > 35 ? 'text-rose-400 font-bold' : 'text-zinc-300' }}">
                                {{ $log->temperature }}&deg;C
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="{{ $log->rainfall_mm > 100 ? 'text-blue-400 font-bold' : 'text-zinc-300' }}">
                                {{ $log->rainfall_mm }} mm
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="{{ $log->soil_moisture < 20 ? 'text-amber-400 font-bold' : 'text-zinc-300' }}">
                                {{ number_format($log->soil_moisture, 2) }}%
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Valid
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-zinc-500">
                            Belum ada log telemetri yang terekam dalam sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
