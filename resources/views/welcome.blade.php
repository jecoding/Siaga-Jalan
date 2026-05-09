<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAGA JALAN - Route Warning & Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #020617; color: white; overflow-x: hidden; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .hero-gradient { background: radial-gradient(circle at top center, rgba(37, 99, 235, 0.15) 0%, transparent 70%); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="hero-gradient min-h-screen">
    <nav class="fixed top-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass px-6 py-3 rounded-2xl">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="font-bold text-xl tracking-tight">SIAGA JALAN</span>
            </div>
            <div class="flex gap-4">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}" class="text-sm font-semibold hover:text-blue-400 Transition">Dashboard</a>
                    @else
                        <a href="{{ url('/tracker') }}" class="text-sm font-semibold hover:text-blue-400 Transition">Tracker</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-blue-400 Transition">Log In</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-32 pb-20 relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-wider">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Real-time Road Safety
                </div>
                <h1 class="text-6xl lg:text-7xl font-extrabold leading-tight">
                    Berkendara Lebih <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">Aman</span> & Terpantau.
                </h1>
                <p class="text-slate-400 text-lg max-w-lg leading-relaxed">
                    SIAGA JALAN membantu Anda memantau area rawan kecelakaan (Black Spots) secara real-time. Dapatkan peringatan instan saat mendekati zona bahaya.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 rounded-2xl font-bold text-lg shadow-xl shadow-blue-600/25 transition transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                    <a href="#features" class="px-8 py-4 glass hover:bg-white/5 rounded-2xl font-bold text-lg transition">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
            <div class="relative lg:block hidden">
                <div class="absolute -inset-4 bg-blue-500/20 blur-3xl rounded-full"></div>
                <div class="glass p-4 rounded-3xl relative animate-float transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1524660988544-232930263301?auto=format&fit=crop&q=80&w=1000" class="rounded-2xl shadow-2xl opacity-80" alt="Dashboard Preview">
                </div>
            </div>
        </div>

        <div id="features" class="mt-32 grid md:grid-cols-3 gap-6">
            <div class="glass p-8 rounded-3xl space-y-4 hover:border-blue-500/40 transition">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold">Real-time Warning</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Notifikasi instan berupa visual dan getaran saat Anda memasuki zona rawan kecelakaan di peta.</p>
            </div>
            <div class="glass p-8 rounded-3xl space-y-4 hover:border-emerald-500/40 transition">
                <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold">Black Spot Map</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Visualisasi data titik rawan kecelakaan yang dikelola oleh administrator untuk keselamatan bersama.</p>
            </div>
            <div class="glass p-8 rounded-3xl space-y-4 hover:border-purple-500/40 transition">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09a13.916 13.916 0 002.103-4.413M15.75 9V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25V9m8.25 2.25h-8.25"></path></svg>
                </div>
                <h3 class="text-xl font-bold">Admin Controls</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Sistem manajemen yang memudahkan admin untuk mengelola dan memantau pergerakan user secara efisien.</p>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-slate-800 flex justify-between items-center text-slate-500 text-sm">
        <p>&copy; 2026 SIAGA JALAN System. All rights reserved.</p>
        <div class="flex gap-6">
            <a href="#" class="hover:text-white transition">Privacy Policy</a>
            <a href="#" class="hover:text-white transition">Terms of Service</a>
        </div>
    </footer>
</body>
</html>
