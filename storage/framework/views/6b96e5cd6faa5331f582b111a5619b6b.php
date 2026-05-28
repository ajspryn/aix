<?php $__env->startSection('content'); ?>
<div class="p-8">
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 tracking-tight">Detail Antrean Tindakan</h1>
            <p class="text-zinc-500 text-sm">Menampilkan informasi lengkap mengenai anomali dan target pendanaan mitigasi.</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded font-bold text-xs uppercase tracking-widest transition-all">
            &larr; Kembali ke Dasbor
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass-panel p-6 rounded-2xl border border-zinc-800 lg:col-span-2">
            <h2 class="text-xl font-bold text-white mb-4">Informasi Kontrak</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Area / Node</div>
                    <div class="text-white font-bold"><?php echo e($contract->monitoredArea ? $contract->monitoredArea->name : 'Unknown'); ?></div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Tipe Anomali</div>
                    <div class="text-rose-400 font-bold capitalize"><?php echo e($contract->monitoredArea ? $contract->monitoredArea->type : 'Unknown'); ?></div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Tingkat Finansial</div>
                    <div class="text-white font-mono">T-<?php echo e($contract->financial_tier); ?></div>
                </div>
                <div class="bg-zinc-900/50 p-4 rounded-xl border border-zinc-800">
                    <div class="text-zinc-500 text-xs mb-1 uppercase tracking-widest">Target Pendanaan (IDR)</div>
                    <div class="text-emerald-400 font-mono font-bold">Rp <?php echo e(number_format($contract->estimated_funding_needed, 0, ',', '.')); ?></div>
                </div>
            </div>

            <h3 class="text-zinc-400 text-sm font-bold mb-2 uppercase tracking-widest">Analisis Situasi:</h3>
            <div class="bg-zinc-900/40 p-4 rounded-xl border border-zinc-800 text-zinc-300 text-sm leading-relaxed mb-6">
                <?php echo e($contract->situational_narrative ?? 'Narasi belum tersedia atau area ini belum dievaluasi oleh sistem.'); ?>

            </div>

            <?php if($contract->status === 'pending'): ?>
            <form action="<?php echo e(route('admin.contracts.start', $contract->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-4 rounded-xl font-bold text-sm uppercase tracking-widest shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all flex justify-center items-center gap-2">
                    Mulai Urun Dana Sekarang
                </button>
            </form>
            <?php endif; ?>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-zinc-800">
            <h2 class="text-xl font-bold text-white mb-4">Metrik Telemetri (10 Terakhir)</h2>
            <div class="space-y-4">
                <?php if($contract->monitoredArea): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $contract->monitoredArea->telemetryLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-zinc-900/50 p-3 rounded-lg border border-zinc-800">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs text-zinc-500"><?php echo e($log->created_at->format('d M H:i')); ?></span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="text-zinc-400">Suhu: <span class="text-white"><?php echo e($log->temperature); ?>&deg;C</span></div>
                            <div class="text-zinc-400">Hujan: <span class="text-white"><?php echo e($log->rainfall_mm); ?>mm</span></div>
                            <div class="text-zinc-400">Kelembaban: <span class="text-white"><?php echo e(number_format($log->soil_moisture, 2)); ?>%</span></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-zinc-600 text-sm py-8">
                        Data telemetri belum terekam.
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center text-zinc-600 text-sm py-8">
                        Tidak ada data Area/Node yang terkait.
                    </div>
                <?php endif; ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $contract->contributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-4 text-zinc-400 font-mono"><?php echo e($trx->created_at->format("Y-m-d H:i:s")); ?></td>
                        <td class="py-4 px-4 text-white font-medium"><?php echo e($trx->donor_name ?? "Anonim"); ?></td>
                        <td class="py-4 px-4 text-emerald-400 font-bold font-mono">Rp <?php echo e(number_format($trx->amount, 0, ",", ".")); ?></td>
                        <td class="py-4 px-4">
                            <?php if($trx->payment_status === "paid" || $trx->payment_status === "settlement" || $trx->payment_status === "success"): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    Berhasil
                                </span>
                            <?php elseif($trx->payment_status === "pending"): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    Tertunda
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <?php echo e(ucfirst($trx->payment_status)); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="py-8 text-center text-zinc-500">
                            Belum ada jalur donasi yang tercatat untuk kontrak ini.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ajspryn/Project/aix/resources/views/admin/contract_detail.blade.php ENDPATH**/ ?>