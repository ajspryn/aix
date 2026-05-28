<?php $__env->startSection('content'); ?>
<div class="bg-gray-100 min-h-screen pb-28">

    <?php
        $heroFallback = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=3000&auto=format&fit=crop';
        $heroImage = isset($contract->monitoredArea->attachments[0])
            ? $contract->monitoredArea->attachments[0]->image_url
            : $heroFallback;
    ?>

    
    
    
    <div class="relative w-full overflow-hidden bg-zinc-950" style="height: 70vh; min-height: 480px;">
        
        <img src="<?php echo e($heroImage); ?>" alt="Foto Wilayah"
             class="absolute inset-0 w-full h-full object-cover opacity-50">
        
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
        
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-950/60 to-transparent h-40"></div>

        
        <div class="absolute inset-0 flex flex-col justify-between max-w-[1400px] mx-auto px-6 sm:px-8 lg:px-12 py-8" style="padding-top: 90px;">

            
            <div>
                <a href="/#contracts-section"
                   class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md hover:bg-white/20 border border-white/20 text-white rounded-full px-5 py-2.5 text-xs font-bold uppercase tracking-widest transition-all">
                    &larr; Kembali ke Radar Induk
                </a>
            </div>

            
            <div>
                <div class="flex flex-wrap items-center gap-2.5 mb-5">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-rose-500 text-white rounded-full text-[11px] font-black uppercase tracking-widest border border-rose-400 shadow-[0_0_20px_rgba(239,68,68,0.4)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        DARURAT TINGKAT <?php echo e($contract->financial_tier); ?>

                    </span>
                    <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full text-[11px] font-bold uppercase tracking-widest">
                        <?php echo e(strtoupper($contract->monitoredArea->type)); ?>

                    </span>
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-indigo-600/80 backdrop-blur-md border border-indigo-400/50 text-white rounded-full text-[11px] font-bold uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Smart Contract Aktif
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white tracking-tighter leading-none max-w-5xl drop-shadow-lg">
                    <?php echo e($contract->monitoredArea->name); ?>

                </h1>
            </div>
        </div>
    </div>

    
    
    
    <div class="max-w-[1400px] mx-auto px-6 sm:px-8 lg:px-12 -mt-2 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            
            
            
            <div class="lg:col-span-8 space-y-8">

                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Populasi Rentan</p>
                        <p class="text-2xl font-black text-gray-900 font-mono"><?php echo e(number_format($contract->monitoredArea->base_population)); ?></p>
                        <p class="text-[10px] text-gray-400 mt-1">jiwa terdampak</p>
                    </div>
                    <div class="bg-rose-50 rounded-2xl p-5 border border-rose-100 shadow-sm">
                        <p class="text-[10px] text-rose-600 font-bold uppercase tracking-widest mb-2">Risiko Bencana</p>
                        <p class="text-2xl font-black text-rose-600 font-mono"><?php echo e($contract->monitoredArea->current_risk_score * 100); ?>%</p>
                        <p class="text-[10px] text-rose-400 mt-1">probabilitas kejadian</p>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 shadow-sm">
                        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mb-2">Validasi AI</p>
                        <span class="inline-block mt-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-200 uppercase tracking-widest">Terkonfirmasi</span>
                    </div>
                    <div class="bg-indigo-50 rounded-2xl p-5 border border-indigo-100 shadow-sm">
                        <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest mb-2">Sensor IoT</p>
                        <span class="inline-block mt-1 text-xs font-bold text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full border border-indigo-200 uppercase tracking-widest">Terhubung</span>
                    </div>
                </div>

                
                <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                        
                        <div class="p-8 lg:p-10">
                            <h3 class="flex items-center gap-2 text-[11px] font-black text-indigo-600 uppercase tracking-widest mb-5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Laporan Situasi
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-[15px]"><?php echo e($contract->narrative['kondisi_saat_ini']); ?></p>
                        </div>
                        
                        <div class="p-8 lg:p-10 bg-gray-50/60">
                            <h3 class="text-[11px] font-black text-gray-500 uppercase tracking-widest mb-5">Indikator Sensor Kritis</h3>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $contract->narrative['parameter_risiko']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $isDanger = in_array($param['status'], ['Berbahaya', 'Kritis Ekstrem', 'Anomali', 'Kritis']); ?>
                                <div class="flex items-center justify-between bg-white p-4 rounded-xl border <?php echo e($isDanger ? 'border-rose-100' : 'border-gray-100'); ?>">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide"><?php echo e($param['nama']); ?></span>
                                    <div class="text-right">
                                        <div class="text-base font-black font-mono text-gray-900"><?php echo e($param['nilai']); ?></div>
                                        <div class="text-[9px] font-bold uppercase tracking-widest <?php echo e($isDanger ? 'text-rose-500' : 'text-emerald-500'); ?>"><?php echo e($param['status']); ?></div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-rose-50 p-8 rounded-3xl border border-rose-100">
                        <h3 class="flex items-center gap-2 text-[11px] font-black text-rose-700 uppercase tracking-widest mb-4">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Skenario Jika Tidak Ditangani
                        </h3>
                        <p class="text-rose-900/80 leading-relaxed text-[14px]"><?php echo e($contract->narrative['skenario_risiko']); ?></p>
                    </div>
                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h3 class="flex items-center gap-2 text-[11px] font-black text-emerald-700 uppercase tracking-widest mb-4">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Rencana Operasi Pencegahan
                        </h3>
                        <p class="text-emerald-900/80 leading-relaxed text-[14px]"><?php echo e($contract->narrative['proposal_mitigasi']); ?></p>
                    </div>
                </div>

                
                <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm relative overflow-hidden">
                    <h3 class="flex items-center gap-2 text-[11px] font-black text-gray-500 uppercase tracking-widest mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pemetaan Titik Risiko (Satelit)
                    </h3>
                    <div class="w-full bg-gray-100 rounded-xl overflow-hidden border border-gray-200 z-10" id="risk-map" style="height: 350px;"></div>
                </div>

                
                <?php if(count($contract->monitoredArea->attachments) > 0): ?>
                <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm">
                    <h3 class="flex items-center gap-2 text-[11px] font-black text-gray-500 uppercase tracking-widest mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Bukti Visual — Satelit & Lapangan
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $contract->monitoredArea->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="aspect-video rounded-xl overflow-hidden bg-gray-100 relative group cursor-zoom-in border border-gray-100">
                            <img src="<?php echo e($att->image_url); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 to-transparent flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-[9px] text-white/70 font-mono mb-0.5">VISUAL_LOG::<?php echo e($loop->iteration); ?></span>
                                <p class="text-[10px] text-white font-medium line-clamp-2"><?php echo e($att->description); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if(count($sentimentSignals) > 0): ?>
                <div class="bg-indigo-50/50 p-8 rounded-3xl border border-indigo-100 shadow-sm">
                    <h3 class="flex items-center gap-2 text-[11px] font-black text-indigo-700 uppercase tracking-widest mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"/></svg>
                        Pemantauan Media & Sinyal Sosial
                    </h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $sentimentSignals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white p-5 rounded-2xl border border-indigo-50 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[9px] font-black uppercase tracking-widest">
                                    <?php echo e($signal->source_type); ?>

                                </span>
                                <span class="text-[10px] text-gray-400 font-mono"><?php echo e($signal->created_at->diffForHumans()); ?></span>
                            </div>
                            <p class="text-[13px] text-gray-700 leading-relaxed italic border-l-2 border-indigo-300 pl-4 py-1">
                                "<?php echo e($signal->raw_text); ?>"
                            </p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-[10px] font-bold uppercase tracking-widest <?php echo e($signal->calculated_sentiment < -0.5 ? 'text-rose-500' : ($signal->calculated_sentiment > 0.5 ? 'text-emerald-500' : 'text-amber-500')); ?>">
                                    Sentimen: <?php echo e($signal->calculated_sentiment < -0.5 ? 'Krisis' : ($signal->calculated_sentiment > 0.5 ? 'Positif' : 'Waspada')); ?> (<?php echo e(round($signal->calculated_sentiment * 100)); ?>%)
                                </div>
                                <?php if($signal->source_link): ?>
                                <a href="<?php echo e($signal->source_link); ?>" target="_blank" class="text-[10px] text-indigo-600 hover:text-indigo-800 font-bold uppercase tracking-widest flex items-center gap-1 group">
                                    Sumber Bacaan 
                                    <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <?php if($sentimentSignals->hasPages()): ?>
                    <div class="mt-6 pt-4 border-t border-indigo-100/50">
                        <?php echo e($sentimentSignals->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>

            
            
            
            <div class="lg:col-span-4 space-y-6">

                
                <div class="sticky top-28 space-y-6">
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">

                        
                        <div class="pb-6 border-b border-gray-100 mb-6">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Estimasi Dana Operasi</p>
                            <div class="text-3xl font-black text-gray-900 font-mono leading-none">
                                <span class="text-sm text-gray-400 font-sans align-top">IDR </span><?php echo e(number_format($contract->estimated_funding_needed, 0)); ?>

                            </div>
                        </div>

                        
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Terkumpul</p>
                                    <p class="text-base font-black text-indigo-600 font-mono">IDR <?php echo e(number_format($contract->current_pooled_funds, 0)); ?></p>
                                </div>
                                <span class="text-sm font-black text-white bg-indigo-600 px-3 py-1 rounded-full"><?php echo e($contract->progress_percent); ?>%</span>
                            </div>
                            <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 rounded-full" style="width: <?php echo e($contract->progress_percent); ?>%"></div>
                            </div>
                        </div>

                        
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Rincian Anggaran (RAB)</p>
                            <div class="space-y-2.5">
                                <?php $__currentLoopData = $contract->narrative['rab_real']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-2">
                                    <span class="shrink-0 text-[10px] font-black text-indigo-500 bg-indigo-50 border border-indigo-100 w-10 text-center py-0.5 rounded-md"><?php echo e($rab['percent']); ?>%</span>
                                    <span class="text-xs text-gray-600 flex-1 truncate"><?php echo e($rab['title']); ?></span>
                                    <span class="shrink-0 text-xs font-bold font-mono text-gray-900">Rp<?php echo e(number_format($rab['amount'], 0)); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        
                        <?php if(session('success_donation')): ?>
                            <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-2xl border border-emerald-200">
                                <?php echo e(session('success_donation')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('error_donation')): ?>
                            <div class="mb-4 p-4 bg-rose-50 text-rose-700 text-xs font-bold rounded-2xl border border-rose-200">
                                <?php echo e(session('error_donation')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('public.contract.donate', $contract->id)); ?>" method="POST" class="space-y-3">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="amount_display" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Nilai Kontribusi (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold font-mono text-sm">Rp</span>
                                    <input type="hidden" name="amount" id="amount_real" required min="10000">
                                    <input type="text" inputmode="numeric" id="amount_display" placeholder="100.000" class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-3 pr-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" style="padding-left: 3rem;" oninput="formatCurrency(this, 'amount_real')">
                                </div>
                                <script>
                                    function formatCurrency(input, realId) {
                                        // Hapus semua karakter selain angka
                                        let value = input.value.replace(/[^0-9]/g, '');
                                        document.getElementById(realId).value = value;
                                        // Gunakan pemisah ribuan titik
                                        if (value) {
                                            input.value = parseInt(value, 10).toLocaleString('id-ID');
                                        } else {
                                            input.value = '';
                                        }
                                    }
                                </script>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-gray-900 hover:bg-black text-white rounded-2xl py-4 font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-[0_8px_24px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_32px_rgba(0,0,0,0.2)]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Otorisasi Pendanaan
                            </button>
                        </form>

                        <div class="mt-4 flex gap-3 bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <p class="text-[10px] text-gray-600 leading-relaxed">Dana dijamin <strong class="text-gray-900">Smart Contract</strong>. Refund otomatis 100% jika situasi membaik sebelum intervensi.</p>
                        </div>
                    </div>

                    
                    <div class="bg-zinc-950 rounded-3xl p-6 border border-zinc-800 shadow-xl">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-800">
                            <span class="flex items-center gap-2 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                                <svg class="w-3.5 h-3.5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M4 15V9a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2z"/></svg>
                                Log Satelit Live
                            </span>
                            <span class="flex items-center gap-1.5 text-[9px] text-emerald-500 font-mono uppercase">
                                Terhubung
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_6px_rgba(16,185,129,0.8)]"></span>
                            </span>
                        </div>
                        <div class="font-mono text-[11px] space-y-3 h-52 overflow-y-auto">
                            <?php $__empty_1 = true; $__currentLoopData = $contract->monitoredArea->telemetryLogs->sortByDesc('created_at')->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div>
                                <span class="text-zinc-600 text-[10px]">[<?php echo e($log->created_at->format('Y-m-d H:i')); ?>]</span>
                                <div class="mt-0.5 text-zinc-300">
                                    <span class="text-indigo-400">INFO</span>
                                    · RN:<span class="text-white"><?php echo e($log->rainfall_mm); ?>mm</span>
                                    · TM:<span class="text-white"><?php echo e($log->temperature); ?>°C</span>
                                    · SM:<span class="text-white"><?php echo e($log->soil_moisture); ?>%</span>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-zinc-600 animate-pulse">Mengunduh data sensor IoT...</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('risk-map')) return;

        const lat = <?php echo e($contract->monitoredArea->latitude); ?>;
        const lng = <?php echo e($contract->monitoredArea->longitude); ?>;
        const riskScore = <?php echo e($contract->monitoredArea->current_risk_score * 100); ?>;
        const areaName = `<?php echo e($contract->monitoredArea->name); ?>`;
        
        // Inisialisasi Peta
        const map = L.map('risk-map', {
            zoomControl: false // Kita matikan default zoom agar lebih clean UI-nya, atau bisa di-custom position
        }).setView([lat, lng], 13);
        
        // Pilihan map tile minimalis (Voyager Carto / Light)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 20,
            subdomains: 'abcd'
        }).addTo(map);

        // Tambah UI Zoom Control di kanan bawah
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Radius warna peringatan (merah/oranye berdasarkan skor risiko)
        const pulseColor = riskScore > 75 ? '#ef4444' : '#f97316'; 

        const circle = L.circle([lat, lng], {
            color: pulseColor,
            fillColor: pulseColor,
            fillOpacity: 0.15,
            weight: 2,
            radius: 1200 // 1.2 KM Impact Radius
        }).addTo(map);
        
        // Custom Marker Darurat
        const criticalIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color: ${pulseColor}; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px ${pulseColor};"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        const marker = L.marker([lat, lng], {icon: criticalIcon}).addTo(map)
            .bindPopup(`<div style="font-family: 'Inter', sans-serif;"><strong style="font-size:12px;display:block;margin-bottom:2px;">${areaName}</strong><span style="font-size:10px;text-transform:uppercase;color:#6b7280;">Potensi Bencana: <b style="color:${pulseColor}">${riskScore}%</b></span></div>`)
            .openPopup();
    });
</script>

<?php if(session()->has('snap_token')): ?>
<?php $snapToken = session()->pull('snap_token'); ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        snap.pay('<?php echo e($snapToken); ?>', {
            onSuccess: function(result){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo e(route('public.contract.success', $contract->id)); ?>';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '<?php echo e(csrf_token()); ?>';
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                alert("Pembayaran kadaluarsa atau gagal!");
                window.location.reload();
            },
            onClose: function(){
                window.location.reload();
            }
        });
    });
</script>
<?php endif; ?>

<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ajspryn/Project/aix/resources/views/public/contract.blade.php ENDPATH**/ ?>