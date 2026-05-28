<!DOCTYPE html>
<html lang="id" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Komando AIX</title>
    <!-- Tailwind CSS v4 via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap');
        body { font-family: 'JetBrains Mono', monospace; }
        .glass-panel { background: rgba(24, 24, 27, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="h-full text-zinc-300 antialiased overflow-hidden flex">
    
    <!-- Sidebar -->
    <aside class="w-64 glass-panel border-r border-zinc-800 flex flex-col items-center py-6 h-full flex-shrink-0">
        <div class="w-12 h-12 rounded bg-gradient-to-br from-rose-600 to-indigo-600 flex items-center justify-center font-bold text-white mb-2">AIX</div>
        <div class="text-xs text-zinc-500 tracking-widest uppercase mb-10">Pusat Komando</div>
        
        <nav class="w-full flex flex-col gap-2 px-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800/50 text-white border border-zinc-700/50' : 'hover:bg-zinc-800/30 text-zinc-400 border border-transparent' }} rounded-lg text-sm font-medium transition-colors"><svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-rose-500' : 'text-zinc-500' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg> Ikhtisar</a>
            <a href="/" class="flex items-center gap-3 px-4 py-3 hover:bg-zinc-800/30 rounded-lg text-zinc-400 border border-transparent text-sm font-medium transition-colors"><svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Portal Publik</a>
            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.analytics') ? 'bg-zinc-800/50 text-white border border-zinc-700/50' : 'hover:bg-zinc-800/30 text-zinc-400 border border-transparent' }} rounded-lg text-sm font-medium transition-colors"><svg class="w-4 h-4 {{ request()->routeIs('admin.analytics') ? 'text-rose-500' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg> Analitik & ROI</a>
            <a href="{{ route('admin.telemetry') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.telemetry') ? 'bg-zinc-800/50 text-white border border-zinc-700/50' : 'hover:bg-zinc-800/30 text-zinc-400 border border-transparent' }} rounded-lg text-sm font-medium transition-colors"><svg class="w-4 h-4 {{ request()->routeIs('admin.telemetry') ? 'text-rose-500' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Log Telemetri</a>
            <a href="{{ route('admin.donations') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.donations') ? 'bg-zinc-800/50 text-white border border-zinc-700/50' : 'hover:bg-zinc-800/30 text-zinc-400 border border-transparent' }} rounded-lg text-sm font-medium transition-colors"><svg class="w-4 h-4 {{ request()->routeIs('admin.donations') ? 'text-rose-500' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Data Donasi</a>
        </nav>
        
        <div class="mt-auto w-full px-4 mb-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 hover:bg-zinc-800/30 rounded-lg text-zinc-500 hover:text-rose-500 text-xs font-semibold uppercase tracking-wider transition-colors border border-transparent hover:border-zinc-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
        
        <div class="mt-auto px-6 w-full text-center text-xs opacity-40">
            SYSTEM V2.04 <br> LURING / AMAN
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto w-full relative">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-900 via-zinc-950 to-zinc-950 -z-10"></div>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>