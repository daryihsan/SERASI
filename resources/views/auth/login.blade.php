<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SERASI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden" x-data="{ 
            selectedNip: '{{ old('nip') }}', 
            users: {{ Js::from($users) }} 
         }">

        <div class="bg-blue-600 p-8 text-center relative overflow-hidden">
            <div
                class="absolute top-0 left-0 w-full h-full bg-blue-500 opacity-20 transform -skew-y-6 origin-bottom-left">
            </div>
            <h1 class="text-3xl font-extrabold text-white relative z-10">SERASI</h1>
            <p class="text-blue-100 text-sm mt-1 relative z-10 font-medium tracking-wide">Modul Inspeksi</p>
        </div>

        <div class="p-8">

            @if (session('error_role'))
                <div
                    class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex gap-3 items-start">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <strong>Akses Ditolak!</strong><br>
                        {{ session('error_role') }}
                    </div>
                </div>
            @endif

            @error('password')
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ $message }}
                </div>
            @enderror

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div class="relative">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pegawai</label>
                        <div class="relative">
                            <select name="nip" x-model="selectedNip"
                                class="w-full border-slate-300 rounded-xl px-4 py-3 bg-slate-50 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all appearance-none cursor-pointer font-medium text-slate-700">
                                <option value="">-- Pilih Nama Anda --</option>
                                <template x-for="user in users" :key="user.nip">
                                    <option :value="user.nip" x-text="user.name"></option>
                                </template>
                            </select>

                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="selectedNip" x-transition
                    class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-400 uppercase tracking-wider">NIP Terdeteksi</span>
                    <span class="font-mono font-bold text-blue-700" x-text="selectedNip"></span>
                    <input type="hidden" name="nip" :value="selectedNip">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 transition-all placeholder-slate-400"
                        placeholder="Masukkan password...">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-95 mt-4">
                    Masuk Aplikasi
                </button>

            </form>
        </div>

        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} SERASI BPOM Semarang. <br>
                Sistem Informasi Layanan Internal.
            </p>
        </div>
    </div>

</body>

</html>