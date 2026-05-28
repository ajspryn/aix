<?php $__env->startSection('content'); ?>
<!-- Premium Interactive Geospatial Risk Map Hero -->
<div class="relative w-full h-[75vh] bg-zinc-950 border-b border-gray-200 overflow-hidden">
    <!-- Map Container -->
    <div id="risk-map" class="absolute inset-0 z-10"></div>
    
    <!-- Gradient Overlays for Depth -->
    <div class="absolute inset-0 z-20 pointer-events-none bg-gradient-to-t from-gray-50 via-transparent to-transparent h-full"></div>
    <div class="absolute inset-0 z-20 pointer-events-none bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-transparent to-zinc-900/50"></div>

    <!-- Floating HUD Elements -->
    <div class="absolute top-28 left-6 md:left-10 z-30 pointer-events-none hidden md:block">
        <div class="bg-black/40 backdrop-blur-2xl border border-white/10 p-6 rounded-3xl shadow-2xl">
            <div class="text-xs text-zinc-400 uppercase tracking-widest font-semibold mb-2">Mesin Analitik Nasional</div>
            <div class="text-3xl font-bold text-white flex items-center gap-4">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                Telemetri Aktif
            </div>
            <div class="mt-6 grid grid-cols-2 gap-8">
                <div>
                    <div class="text-[10px] text-zinc-500 uppercase tracking-wider mb-1">Node Pemindaian</div>
                    <div class="text-xl font-mono text-zinc-200">1,402</div>
                </div>
                <div>
                    <div class="text-[10px] text-zinc-500 uppercase tracking-wider mb-1">Zona Kritis</div>
                    <div class="text-xl font-mono text-rose-400 font-bold"><?php echo e($openContracts->count()); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Legend -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-30 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-xl px-8 py-4 rounded-full shadow-2xl border border-gray-100 flex items-center gap-8 text-xs font-bold uppercase tracking-wider text-gray-800">
            <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_12px_rgba(16,185,129,0.5)]"></span> Stabil</div>
            <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-amber-400 shadow-[0_0_12px_rgba(251,191,36,0.5)]"></span> Peringatan</div>
            <div class="flex items-center gap-3"><span class="w-3.5 h-3.5 rounded-full bg-rose-500 animate-pulse shadow-[0_0_15px_rgba(244,63,94,0.8)] border-2 border-rose-200"></span> Intervensi</div>
        </div>
    </div>
</div>

<div id="contracts-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 scroll-mt-24">
    <div class="mb-20 text-center max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-100 text-rose-600 text-xs font-bold uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span> Operasi Langsung
        </div>
        <h3 class="text-5xl font-extrabold tracking-tight text-gray-900 mb-6 leading-[1.1]">Mitigasi Proaktif<br/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">Membutuhkan Tindakan Anda</span></h3>
        <p class="text-xl text-gray-500 font-light leading-relaxed">Mesin AIX telah mengidentifikasi anomali geografis kritis. Danai logistik preventif sekarang juga sebelum efek pengganda bencana terjadi.</p>
    </div>

    <!-- Active Crowdfunding Progress Grid (Top 3) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        <?php $__currentLoopData = $topContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalcc1de79df802125ed75811c4188ec80c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc1de79df802125ed75811c4188ec80c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contract-card','data' => ['contract' => $contract]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contract-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contract' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contract)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $attributes = $__attributesOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__attributesOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $component = $__componentOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__componentOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Background Risk Monitoring Roll (Marquee Carousel) -->
    <?php if($otherContracts->count() > 0): ?>
    <div class="relative max-w-7xl mx-auto mb-20 overflow-hidden">
        <div class="text-xs text-gray-400 font-bold uppercase tracking-widest pl-4 mb-6 border-l-2 border-gray-200">
            Antrean Sensor Lainnya ($<?php echo e($otherContracts->count()); ?> Zona)
        </div>
        
        <!-- Overflow Wrapper & Drag Scroll -->
        <div class="group relative">
            <div id="sensor-carousel" class="flex overflow-x-auto gap-6 hide-scrollbar cursor-grab active:cursor-grabbing pb-4">
                <?php $__currentLoopData = $otherContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-[240px] flex-none transition-transform duration-300">
                        <?php if (isset($component)) { $__componentOriginalcc1de79df802125ed75811c4188ec80c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc1de79df802125ed75811c4188ec80c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contract-card','data' => ['contract' => $contract,'compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contract-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contract' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contract),'compact' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $attributes = $__attributesOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__attributesOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $component = $__componentOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__componentOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- Duplicate array for seamless wrap behavior using JS -->
                <?php $__currentLoopData = $otherContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-[240px] flex-none transition-transform duration-300">
                        <?php if (isset($component)) { $__componentOriginalcc1de79df802125ed75811c4188ec80c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc1de79df802125ed75811c4188ec80c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contract-card','data' => ['contract' => $contract,'compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contract-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['contract' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($contract),'compact' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $attributes = $__attributesOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__attributesOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc1de79df802125ed75811c4188ec80c)): ?>
<?php $component = $__componentOriginalcc1de79df802125ed75811c4188ec80c; ?>
<?php unset($__componentOriginalcc1de79df802125ed75811c4188ec80c); ?>
<?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const slider = document.getElementById('sensor-carousel');
                    let isDown = false;
                    let startX;
                    let scrollLeft;
                    let autoScrollTimer;

                    // Manual Drag Scroll
                    slider.addEventListener('mousedown', (e) => {
                        isDown = true;
                        slider.classList.add('cursor-grabbing');
                        slider.classList.remove('cursor-grab');
                        startX = e.pageX - slider.offsetLeft;
                        scrollLeft = slider.scrollLeft;
                        clearInterval(autoScrollTimer);
                    });
                    slider.addEventListener('mouseleave', () => {
                        isDown = false;
                        slider.classList.remove('cursor-grabbing');
                        slider.classList.add('cursor-grab');
                        startAutoScroll();
                    });
                    slider.addEventListener('mouseup', () => {
                        isDown = false;
                        slider.classList.remove('cursor-grabbing');
                        slider.classList.add('cursor-grab');
                        startAutoScroll();
                    });
                    slider.addEventListener('mousemove', (e) => {
                        if (!isDown) return;
                        e.preventDefault();
                        const x = e.pageX - slider.offsetLeft;
                        const walk = (x - startX) * 2; 
                        slider.scrollLeft = scrollLeft - walk;
                    });

                    // Auto Roll Logic Custom
                    const startAutoScroll = () => {
                        clearInterval(autoScrollTimer);
                        autoScrollTimer = setInterval(() => {
                            if (!isDown && !slider.matches(':hover')) {
                                slider.scrollLeft += 1;
                                // Reset to start for infinite illusion when end is reached
                                if (slider.scrollLeft >= (slider.scrollWidth / 2)) {
                                    slider.scrollLeft = 0;
                                }
                            }
                        }, 25);
                    };
                    
                    slider.addEventListener('mouseenter', () => clearInterval(autoScrollTimer));
                    slider.addEventListener('touchstart', () => clearInterval(autoScrollTimer));
                    slider.addEventListener('touchend', startAutoScroll);

                    startAutoScroll();
                });
            </script>
        </div>
        
        <!-- Side Fade effects -->
        <div class="absolute top-0 right-0 h-full w-24 bg-gradient-to-l from-slate-50 to-transparent pointer-events-none z-10"></div>
        <div class="absolute top-0 left-0 h-full w-24 bg-gradient-to-r from-slate-50 to-transparent pointer-events-none z-10"></div>
    </div>
    <?php endif; ?>
</div>

<!-- Educational & Trust Section -->
<div id="mechanism-section" class="bg-white border-t border-gray-100 mt-12 py-24 relative overflow-hidden scroll-mt-24">
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full max-w-7xl h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- How it works -->
        <div class="mb-32 relative">
            <div class="text-center max-w-3xl mx-auto mb-20 relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-50 border border-rose-100 text-rose-600 text-[10px] font-bold uppercase tracking-widest mb-6 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Protokol Operasi
                </div>
                <h3 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-6">Bagaimana AIX Bekerja?</h3>
                <p class="text-lg text-gray-500 font-light leading-relaxed">
                    Mengubah respons bencana dari pendekatan reaktif reaksioner menjadi 
                    <span class="font-semibold text-rose-600">intervensi pencegahan proaktif</span> berbasis algoritma prediktif.
                </p>
            </div>
            
            <div class="relative max-w-5xl mx-auto">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-[radial-gradient(ellipse_at_center,rgba(244,63,94,0.05)_0%,transparent_70%)] pointer-events-none -z-10"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 relative z-10">
                    <!-- Progress Line (Mobile Hidden, Desktop Absolute) -->
                    <div class="hidden md:block absolute top-[4.5rem] left-[16%] right-[16%] h-0.5 bg-gradient-to-r from-emerald-400 via-amber-400 to-rose-500 z-0 opacity-50"></div>
                    <div class="hidden md:block absolute top-[4.5rem] left-[16%] right-[16%] h-0.5 bg-[linear-gradient(90deg,transparent_0%,rgba(255,255,255,0.8)_50%,transparent_100%)] bg-[length:20px_100%] animate-[slide_2s_linear_infinite] z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-b from-emerald-100 to-transparent rounded-[2rem] transform scale-95 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-500 z-0"></div>
                        <div class="relative bg-white p-8 rounded-[2xl] border border-gray-100 shadow-xl shadow-gray-200/40 text-center h-full z-10 flex flex-col items-center">
                            <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-emerald-100 relative group-hover:-translate-y-2 transition-transform duration-500">
                                <div class="absolute -right-2 -top-2 w-6 h-6 bg-emerald-500 text-white rounded-full text-xs font-bold flex items-center justify-center shadow-lg border-2 border-white">1</div>
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3 tracking-tight">Deteksi Telemetri</h4>
                            <p class="text-sm text-gray-500 leading-relaxed font-light">Sensor IoT, satelit geomapping, dan feed cuaca secara konstan memantau anomali dari seluruh wilayah Nusantara waktu-nyata.</p>
                            <div class="mt-6 pt-6 border-t border-gray-100 w-full">
                                <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">Stream Aktif</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="relative group mt-8 md:mt-0">
                        <div class="absolute inset-0 bg-gradient-to-b from-amber-100 to-transparent rounded-[2rem] transform scale-95 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-500 z-0"></div>
                        <div class="relative bg-white p-8 rounded-[2xl] border border-gray-100 shadow-xl shadow-gray-200/40 text-center h-full z-10 flex flex-col items-center">
                            <div class="w-20 h-20 bg-amber-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-amber-100 relative group-hover:-translate-y-2 transition-transform duration-500">
                                <div class="absolute -right-2 -top-2 w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold flex items-center justify-center shadow-lg border-2 border-white">2</div>
                                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3 tracking-tight">Kalkulasi AIX Engine</h4>
                            <p class="text-sm text-gray-500 leading-relaxed font-light">Sistem menghitung kerugian eksponensial vs biaya intervensi pencegahan instan, menghasilkan matriks probabilitas ancaman.</p>
                            <div class="mt-6 pt-6 border-t border-gray-100 w-full">
                                <span class="text-[10px] text-amber-600 font-bold uppercase tracking-widest bg-amber-50 px-3 py-1 rounded-full border border-amber-100">Proses Data</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="relative group mt-8 md:mt-0">
                        <div class="absolute inset-0 bg-gradient-to-b from-rose-100 to-transparent rounded-[2rem] transform scale-95 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-500 z-0"></div>
                        <div class="relative bg-white p-8 rounded-[2xl] border border-gray-100 shadow-xl shadow-gray-200/40 text-center h-full z-10 flex flex-col items-center">
                            <div class="w-20 h-20 bg-rose-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner border border-rose-100 relative group-hover:-translate-y-2 transition-transform duration-500">
                                <div class="absolute -right-2 -top-2 w-6 h-6 bg-rose-500 text-white rounded-full text-xs font-bold flex items-center justify-center shadow-lg border-2 border-white">3</div>
                                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3 tracking-tight">Intervensi Kolektif</h4>
                            <p class="text-sm text-gray-500 leading-relaxed font-light">Dana didistribusikan presisi (Just-In-Time) saat ancaman menembus batas. Bencana skala besar berhasil digagalkan dari awal.</p>
                            <div class="mt-6 pt-6 border-t border-gray-100 w-full">
                                <span class="text-[10px] text-rose-600 font-bold uppercase tracking-widest bg-rose-50 px-3 py-1 rounded-full animate-pulse border border-rose-200">Urun Dana</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust & Transparency -->
        <div>
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h3 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4">Mengapa Mempercayai Platform Ini?</h3>
                <p class="text-lg text-gray-500 font-light leading-relaxed">Integritas struktural tanpa kompromi, audit real-time, dan kolaborasi multi-lembaga divalidasi oleh publik.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="flex gap-6 items-start p-6 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-gray-200/40 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Audit Transparansi Otomatis</h4>
                        <p class="text-sm text-gray-500 leading-relaxed text-balance">Setiap dana dicatatkan dalam buku besar publik terbuka. Kami menjamin 100% donasi langsung dialokasikan ke operasional mitigasi lapangan tanpa potongan administrasi terselubung.</p>
                    </div>
                </div>
                
                <div class="flex gap-6 items-start p-6 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-gray-200/40 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Didukung Model Data Sains</h4>
                        <p class="text-sm text-gray-500 leading-relaxed text-balance">Tidak ada asumsi dalam intervensi kami; peringatan krisis murni dipicu oleh model prediksi berbasis satelit, harga komoditas makro, serta deteksi kecemasan sentimen publik (NLP).</p>
                    </div>
                </div>
                
                <div class="flex gap-6 items-start p-6 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-gray-200/40 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Otoritas Pusat Komando Resmi</h4>
                        <p class="text-sm text-gray-500 leading-relaxed text-balance">Dioperasikan secara terpusat dan terhubung dengan badan penanggulangan tanggap darurat resmi untuk pergerakan logistik skala besar (rapid deployment) dalam waktu kurang dari 24 jam.</p>
                    </div>
                </div>
                
                <div class="flex gap-6 items-start p-6 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-gray-200/40 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Jaminan Pengembalian (Refund)</h4>
                        <p class="text-sm text-gray-500 leading-relaxed text-balance">Platform yang adil. Jika anomali zona peringatan membaik secara organik sebelum dana terkumpul / dikerahkan, dana akan dikembalikan penuh (refund) ke dompet digital donatur secara tertaut.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slide {
  from { background-position: 0 0; }
  to { background-position: 20px 20px; }
}
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Init map with darker theme base layer for premium feel
        const map = L.map('risk-map', { zoomControl: false, scrollWheelZoom: false }).setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors & CARTO'
        }).addTo(map);

        fetch('/api/geojson-risks')
            .then(res => res.json())
            .then(data => {
                const geoJsonLayer = L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
                        let innerClass = 'bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.8)]';
                        let outerPing = '';
                        let ringColor = 'border-emerald-200';
                        
                        if(feature.properties.status === 'critical' || feature.properties.status === 'open') {
                            innerClass = 'bg-rose-500 shadow-[0_0_20px_rgba(244,63,94,1)]';
                            outerPing = '<div class="absolute inset-0 rounded-full animate-ping bg-rose-500 opacity-60"></div>';
                            ringColor = 'border-rose-300';
                        } else if (feature.properties.status === 'warning') {
                            innerClass = 'bg-amber-400 shadow-[0_0_15px_rgba(251,191,36,0.8)]';
                            ringColor = 'border-amber-200';
                        }
                        
                        const markerHtml = `
                            <div class="relative flex items-center justify-center w-6 h-6">
                                ${outerPing}
                                <div class="absolute w-4 h-4 rounded-full border-[3px] ${ringColor} ${innerClass} z-10"></div>
                            </div>
                        `;
                        const icon = L.divIcon({ html: markerHtml, className: '', iconSize: [24,24], iconAnchor: [12, 12] });
                        
                        let formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(feature.properties.target_funds);
                        
                        let badgeColor = feature.properties.status === 'open' ? 'bg-rose-50' : (feature.properties.status === 'warning' ? 'bg-amber-50' : 'bg-emerald-50');
                        let badgeText = feature.properties.status === 'open' ? 'text-rose-600' : (feature.properties.status === 'warning' ? 'text-amber-600' : 'text-emerald-600');
                        let badgeBorder = feature.properties.status === 'open' ? 'border-rose-200' : (feature.properties.status === 'warning' ? 'border-amber-200' : 'border-emerald-200');
                        let gradientColor = feature.properties.status === 'open' ? 'via-rose-500' : (feature.properties.status === 'warning' ? 'via-amber-500' : 'via-emerald-500');

                        let actionButton = '';
                        if (feature.properties.contract_id) {
                            actionButton = `
                                <a href="/krisis/${feature.properties.contract_id}" class="mt-4 flex items-center justify-center gap-2 w-full text-center bg-slate-900 text-white px-4 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-rose-500 hover:shadow-lg hover:shadow-rose-500/30 transition-all duration-300 group">
                                    Buka Detail Operasi <span class="group-hover:translate-x-1 transition-transform">→</span>
                                </a>`;
                        } else {
                            actionButton = `
                                <div class="mt-4 flex items-center justify-center gap-2 w-full text-center bg-slate-50 text-slate-400 px-4 py-3 rounded-xl text-[10px] border border-slate-200 font-bold uppercase tracking-widest">
                                    Pantauan Stabil
                                </div>`;
                        }

                        return L.marker(latlng, {icon: icon})
                            .bindPopup(`
                                <div class="w-72 overflow-hidden bg-white/95 backdrop-blur-3xl rounded-[1.25rem] border border-slate-200/60 shadow-[0_20px_40px_rgba(0,0,0,0.08)]">
                                    <div class="h-1.5 w-full bg-slate-100">
                                        <div class="h-full bg-gradient-to-r from-transparent ${gradientColor} to-transparent" style="width: ${feature.properties.risk_score * 100}%"></div>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mb-1.5">Sensor Node Terkonfirmasi</div>
                                                <h4 class="font-extrabold text-slate-900 text-[15px] leading-tight drop-shadow-sm">${feature.properties.name}</h4>
                                            </div>
                                            <span class="px-2.5 py-1 rounded-md ${badgeColor} ${badgeText} border ${badgeBorder} text-[9px] font-extrabold uppercase tracking-wider shadow-sm flex items-center gap-1">
                                                ${feature.properties.severity_level}
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                            <div class="bg-slate-50/80 rounded-xl p-2.5 border border-slate-100 hover:border-slate-200 transition-colors">
                                                <div class="text-[8px] text-slate-400 font-bold uppercase tracking-widest mb-1">Indeks Ancaman</div>
                                                <div class="text-sm font-mono font-extrabold text-rose-500">${(feature.properties.risk_score * 100).toFixed(0)}%</div>
                                            </div>
                                            <div class="bg-slate-50/80 rounded-xl p-2.5 border border-slate-100 hover:border-slate-200 transition-colors">
                                                <div class="text-[8px] text-slate-400 font-bold uppercase tracking-widest mb-1">Anomali</div>
                                                <div class="text-sm font-bold text-slate-700 capitalize">${feature.properties.type}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2 bg-slate-50/50 p-2.5 rounded-xl border border-slate-100">
                                            <div class="flex justify-between items-end">
                                                <div class="text-[8px] text-slate-400 font-bold uppercase tracking-widest">Est. Biaya Operasi</div>
                                                <div class="text-[11px] font-mono font-bold text-slate-700">${formatRupiah}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-between items-center text-slate-400 text-[8px] uppercase tracking-widest font-bold px-1 mt-1">
                                            <span>SINKRONISASI SATELIT</span>
                                            <span>${feature.properties.last_updated}</span>
                                        </div>

                                        ${actionButton}
                                    </div>
                                </div>
                            `, {
                                className: 'custom-popup pointer-events-auto',
                                closeButton: false,
                                offset: [0, -10]
                            });
                    }
                });
                
                const markers = L.markerClusterGroup({
                    chunkedLoading: true,
                    maxClusterRadius: 60,
                    iconCreateFunction: function(cluster) {
                        return L.divIcon({
                            html: `<div class="w-12 h-12 rounded-full bg-rose-500/20 flex items-center justify-center border-2 border-rose-400 backdrop-blur-md shadow-[0_0_15px_rgba(244,63,94,0.5)]"><div class="text-white font-extrabold text-sm bg-rose-500 rounded-full w-9 h-9 flex items-center justify-center shadow-lg">${cluster.getChildCount()}</div></div>`,
                            className: 'cluster-icon pointer-events-auto',
                            iconSize: [48, 48],
                            iconAnchor: [24, 24]
                        });
                    }
                });
                
                markers.addLayer(geoJsonLayer);
                map.addLayer(markers);
            });
    });
</script>
<style>
    /* Leaflet popup overrides */
    .leaflet-popup-content-wrapper { background: transparent; border-radius: 12px; box-shadow: none; padding: 0; }
    .leaflet-popup-tip-container { display: none; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('public.layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ajspryn/Project/aix/resources/views/public/explore.blade.php ENDPATH**/ ?>