@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Monitoring Donasi</h1>
            <p class="text-zinc-500 text-sm">Riwayat kontribusi dari portal publik secara real-time</p>
        </div>
    </header>

    <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Waktu Kontribusi</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Nama Donatur</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Nominal (IDR)</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Target / Node Area</th>
                        <th class="border-b border-zinc-800 py-4 px-4 text-xs uppercase tracking-widest text-zinc-500 font-semibold">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($contributions as $trx)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-4 text-zinc-400 font-mono">{{ $trx->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="py-4 px-4 text-white font-medium">{{ $trx->donor_name ?? 'Anonim' }}</td>
                        <td class="py-4 px-4 text-emerald-400 font-bold font-mono">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 text-zinc-300">
                           <a href="{{ route('admin.contracts.show', $trx->impact_contract_id) }}" class="hover:text-indigo-400 transition-colors">
                               {{ $trx->contract && $trx->contract->monitoredArea ? $trx->contract->monitoredArea->name : 'Kontrak Tidak Ditemukan' }}
                           </a>
                        </td>
                        <td class="py-4 px-4">
                            @if($trx->payment_status === 'paid' || $trx->payment_status === 'settlement' || $trx->payment_status === 'success')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    Berhasil
                                </span>
                            @elseif($trx->payment_status === 'pending')
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
                        <td colspan="5" class="py-8 text-center text-zinc-500">
                            Belum ada jalur donasi yang tercatat dalam log pembayaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $contributions->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
