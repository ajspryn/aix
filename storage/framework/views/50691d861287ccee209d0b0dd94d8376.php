<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIX | Anticipatory Impact Exchange</title>
    <!-- Tailwind CSS v4 via Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased selection:bg-rose-500 selection:text-white">
    <nav class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-5xl bg-white/70 backdrop-blur-xl border border-white/50 shadow-2xl shadow-gray-200/40 rounded-full px-2 py-2 transition-all duration-300">
        <div class="flex justify-between items-center w-full px-3 text-sm font-medium text-gray-700">
            <!-- Logo Section -->
            <a href="/" class="flex items-center gap-3 w-1/4 group cursor-pointer drop-shadow-sm">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-rose-500 to-orange-400 flex items-center justify-center shadow-lg shadow-rose-200 group-hover:shadow-rose-300 transition-all duration-300 group-hover:scale-105">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-[15px] text-gray-900 leading-none tracking-tight">AIX</span>
                    <span class="text-[8px] uppercase tracking-[0.2em] text-gray-500 font-bold mt-0.5">Portal</span>
                </div>
            </a>

            <!-- Central Navigation Menu -->
            <div class="hidden md:flex flex-1 justify-center items-center gap-1 bg-gray-100/50 p-1.5 rounded-full border border-gray-200/60 shadow-inner">
                <a href="#risk-map" class="px-5 py-2 rounded-full text-gray-800 hover:text-rose-600 hover:bg-white hover:shadow-sm hover:shadow-gray-200/50 transition-all font-bold tracking-wide text-xs">Peta Risiko</a>
                <a href="#contracts-section" class="px-5 py-2 rounded-full text-gray-500 hover:text-rose-600 hover:bg-white hover:shadow-sm hover:shadow-gray-200/50 transition-all font-bold tracking-wide text-xs">Urun Dana</a>
                <a href="#mechanism-section" class="px-5 py-2 rounded-full text-gray-500 hover:text-rose-600 hover:bg-white hover:shadow-sm hover:shadow-gray-200/50 transition-all font-bold tracking-wide text-xs">Bagaimana Bekerja</a>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center justify-end gap-3 w-1/4">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="hidden lg:block text-xs font-bold uppercase tracking-widest text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-300 hover:bg-white px-4 py-2.5 rounded-full transition-all shadow-sm">Command Center</a>
                    <?php endif; ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-rose-600 px-3 py-2 transition-colors">Keluar</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest transition-all shadow-lg hover:shadow-xl hover:shadow-gray-400/30 hover:-translate-y-0.5 border border-transparent flex items-center gap-2 group">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)] animate-pulse"></span>
                        Akses Portal
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="w-full">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-zinc-950 text-zinc-400 py-16 border-t border-zinc-900 mt-20 relative overflow-hidden">
        <!-- Subtle background glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-px bg-gradient-to-r from-transparent via-rose-500/30 to-transparent"></div>
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-rose-500/10 blur-[120px] rounded-full pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand Column -->
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center gap-3 mb-6 inline-flex group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-rose-500 to-orange-400 flex items-center justify-center shadow-lg shadow-rose-500/20 group-hover:shadow-rose-400/40 transition-shadow duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl text-white leading-none tracking-tight">AIX</span>
                            <span class="text-[9px] uppercase tracking-[0.2em] text-zinc-500 font-bold mt-1">Anticipatory Impact Exchange</span>
                        </div>
                    </a>
                    <p class="text-sm text-zinc-400 leading-relaxed font-light max-w-md">
                        Platform mitigasi bencana berbasis kecerdasan buatan pertama di Indonesia. Mengubah respons darurat reaktif menjadi intervensi pencegahan proaktif melalui komputasi telemetri dan urun dana publik waktu-nyata.
                    </p>
                    <div class="mt-8 flex items-center gap-3">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-mono tracking-widest text-emerald-500 uppercase">Protokol Induk Aktif</span>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-sm uppercase">Navigasi Utama</h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="#risk-map" class="hover:text-rose-400 transition-colors flex items-center gap-2"><span class="text-zinc-700">/</span> Peta Geo-Spasial</a></li>
                        <li><a href="#contracts-section" class="hover:text-rose-400 transition-colors flex items-center gap-2"><span class="text-zinc-700">/</span> Operasi Urun Dana</a></li>
                        <li><a href="#mechanism-section" class="hover:text-rose-400 transition-colors flex items-center gap-2"><span class="text-zinc-700">/</span> Mekanisme AIX</a></li>
                    </ul>
                </div>

                <!-- Legal & Contact -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide text-sm uppercase">Legal & Otoritas</h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="#" class="hover:text-rose-400 transition-colors">Terminologi Platform</a></li>
                        <li><a href="#" class="hover:text-rose-400 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-rose-400 transition-colors">Prosedur Refund Dana</a></li>
                        <li><a href="#" class="text-rose-400 hover:text-white transition-colors border-b border-rose-500/30 pb-0.5">Hubungi Command Center</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-zinc-800/50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-zinc-500 text-xs text-center md:text-left tracking-wide">
                    &copy; <?php echo e(date('Y')); ?> AIX Anticipatory Impact Exchange.<br class="md:hidden"/> Hak cipta dilindungi undang-undang keamanan siber.
                </div>
                <!-- Social Connectors -->
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-900 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all text-zinc-500 border border-zinc-800 hover:border-transparent hover:-translate-y-1 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-900 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all text-zinc-500 border border-zinc-800 hover:border-transparent hover:-translate-y-1 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /Users/ajspryn/Project/aix/resources/views/public/layouts/portal.blade.php ENDPATH**/ ?>