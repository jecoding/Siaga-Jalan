<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIAGA JALAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: white; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 space-y-6 bg-slate-800 rounded-xl shadow-2xl border border-slate-700">
        <div class="text-center">
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">SIAGA JALAN</h1>
            <p class="text-slate-400 mt-2">Masuk ke akun Anda</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            @if (session('status'))
                <div class="p-3 text-sm text-emerald-500 bg-emerald-500/10 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 text-sm text-red-500 bg-red-500/10 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-300">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                <input type="password" name="password" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <button type="submit" class="w-full py-2 px-4 shadow-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg transition transform active:scale-95">
                Masuk
            </button>
        </form>
        
        <div class="text-center text-sm text-slate-400 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Daftar di sini</a>
        </div>
    </div>
</body>
</html>
