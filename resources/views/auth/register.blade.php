<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIAGA JALAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: white; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen my-8">
    <div class="w-full max-w-md p-8 space-y-6 bg-slate-800 rounded-xl shadow-2xl border border-slate-700">
        <div class="text-center">
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">SIAGA JALAN</h1>
            <p class="text-slate-400 mt-2">Buat akun baru</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            @if ($errors->any())
                <div class="p-3 text-sm text-red-500 bg-red-500/10 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-300">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300">Jenis Kendaraan</label>
                <select name="vehicle_type" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition appearance-none">
                    <option value="" disabled {{ old('vehicle_type') ? '' : 'selected' }}>Pilih Jenis Kendaraan</option>
                    <option value="Motor" {{ old('vehicle_type') == 'Motor' ? 'selected' : '' }}>Motor</option>
                    <option value="Mobil" {{ old('vehicle_type') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="Truk" {{ old('vehicle_type') == 'Truk' ? 'selected' : '' }}>Truk</option>
                    <option value="Bus" {{ old('vehicle_type') == 'Bus' ? 'selected' : '' }}>Bus</option>
                    <option value="Lainnya" {{ old('vehicle_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                <input type="password" name="password" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required 
                    class="w-full mt-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-white transition">
            </div>

            <button type="submit" class="w-full py-2 px-4 shadow-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg transition transform active:scale-95">
                Daftar
            </button>
        </form>
        
        <div class="text-center text-sm text-slate-400 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
