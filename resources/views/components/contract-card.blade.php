@props(['contract', 'compact' => false])

<div id="contract-{{ $contract->id }}" class="group relative bg-white rounded-{{ $compact ? '2xl' : '[2rem]' }} overflow-hidden shadow-xl shadow-gray-200/40 border border-gray-100 flex flex-col h-full transition-all hover:shadow-2xl hover:shadow-rose-100/50 hover:-translate-y-1 duration-500 whitespace-normal">
    <!-- Visual Evidence Gallery Tray -->
    <div class="relative {{ $compact ? 'h-32' : 'h-48' }} overflow-hidden bg-zinc-100 shrink-0">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute top-3 border border-white/20 right-3 z-20 px-3 py-1 bg-rose-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg flex items-center gap-1.5">
            Tingkat {{ $contract->financial_tier }}
        </div>
        <div class="absolute bottom-3 left-3 z-20">
            <span class="text-white/80 font-mono text-[10px] tracking-widest drop-shadow-md">RES: {{ ($contract->monitoredArea->current_risk_score * 100) }}%</span>
        </div>
        <div class="flex h-full w-full">
            @forelse($contract->monitoredArea->attachments ?? [] as $attachment)
            <div class="flex-none w-full h-full relative">
                <img src="{{ $attachment->image_url }}" alt="Bukti Visual" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
            </div>
            @empty
            <div class="flex-none w-full h-full bg-zinc-100 flex items-center justify-center text-zinc-400">
                <span class="text-[10px] font-bold tracking-widest uppercase flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg> Uplink Sensor</span>
            </div>
            @endforelse
        </div>
    </div>
    
    <div class="{{ $compact ? 'p-5' : 'p-6 md:p-8' }} flex-1 flex flex-col">
        <h3 class="{{ $compact ? 'text-[15px]' : 'text-xl' }} font-extrabold text-gray-900 mb-2 tracking-tight line-clamp-2 w-full">{{ $contract->monitoredArea->name }}</h3>
        <p class="text-gray-500 {{ $compact ? 'text-[11px] mb-4' : 'text-[13px] mb-6' }} leading-relaxed line-clamp-3 w-full">{{ $contract->automated_mitigation_plan }}</p>
        
        @if(!$compact)
        <!-- AI Comparative Grid Component -->
        <div class="grid grid-cols-1 gap-3 mb-8">
            <div class="p-4 rounded-[1rem] border border-rose-100 bg-gradient-to-br from-rose-50/80 to-transparent relative group/opt">
                <div class="text-[9px] text-rose-500 font-bold uppercase tracking-widest mb-1 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Estimasi Kerugian Bencana</div>
                <div class="text-rose-700 font-mono text-sm font-bold">IDR {{ number_format($contract->monitoredArea->base_population * 1500000, 0) }}</div>
            </div>
            <div class="p-4 rounded-[1rem] border border-emerald-100 bg-gradient-to-br from-emerald-50 to-emerald-50/30 relative">
                <div class="text-[9px] text-emerald-600 font-bold uppercase tracking-widest mb-1 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Biaya Pencegahan (AIX)</div>
                <div class="text-emerald-700 font-mono text-sm font-bold flex items-center gap-1">
                    IDR {{ number_format($contract->estimated_funding_needed, 0) }}
                </div>
            </div>
        </div>
        @endif

        <div class="mt-auto">
            <div class="space-y-3 {{ $compact ? 'mb-4' : 'mb-6' }} w-full">
                <div class="flex justify-between items-end w-full">
                    <div class="min-w-0">
                        <div class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mb-0.5 truncate w-full">Dana Terkumpul</div>
                        <div class="{{ $compact ? 'text-[13px]' : 'text-[16px]' }} font-bold font-mono text-gray-900 tracking-tight truncate w-full leading-none">IDR {{ number_format($contract->current_pooled_funds, 0) }}</div>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full {{ $compact ? 'h-1.5' : 'h-2' }} overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-rose-500 via-orange-400 to-amber-300 h-full rounded-full relative" style="width: {{ $contract->progress_percent }}%"></div>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                @if(!$compact)
                <a href="{{ route('public.contract.show', $contract->id) }}" class="w-full bg-white border border-gray-200 hover:border-gray-900 hover:bg-gray-50 text-gray-900 rounded-xl py-3 font-bold text-xs transition-all flex items-center justify-center gap-2">
                    Cek Detail Operasi
                </a>
                <button class="w-full bg-gray-900 hover:bg-black text-white rounded-xl py-3 font-bold text-xs transition-all flex items-center justify-center gap-2 shadow-md">
                    Danai Instan
                </button>
                @else
                <!-- Compact action button -->
                <a href="{{ route('public.contract.show', $contract->id) }}" class="w-full bg-gray-900 hover:bg-black text-white rounded-xl py-2.5 font-bold text-[10px] transition-all flex items-center justify-center gap-2 shadow-md">
                    Cek Analisa
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
