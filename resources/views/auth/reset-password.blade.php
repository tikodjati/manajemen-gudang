<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Reset Password - Sistem Informasi Administrasi Orderan</title>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8 m-4">
        <div class="text-center mb-8">
            <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                <span class="text-white text-3xl">🔑</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Reset Password</h2>
            <p class="text-slate-500 text-sm">Gunakan 12 kata rahasia untuk memulihkan akun</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <ul class="text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Email Terdaftar</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full p-3 rounded-xl bg-slate-100 border-2 border-transparent outline-none focus:border-blue-500 focus:bg-white transition-all" 
                    placeholder="nama@mail.com">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">12 Kata Rahasia (Recovery Phrase)</label>
                <textarea name="recovery_phrase" rows="3" required
                    class="w-full p-3 rounded-xl bg-slate-100 border-2 border-transparent outline-none focus:border-blue-500 focus:bg-white transition-all resize-none"
                    placeholder="satu dua tiga..."></textarea>
            </div>

            <hr class="my-6 border-slate-100">

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Password Baru</label>
                <input type="password" name="password" required
                    class="w-full p-3 rounded-xl bg-slate-100 border-2 border-transparent outline-none focus:border-blue-500 focus:bg-white transition-all"
                    placeholder="••••••••">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required
                    class="w-full p-3 rounded-xl bg-slate-100 border-2 border-transparent outline-none focus:border-blue-500 focus:bg-white transition-all"
                    placeholder="••••••••">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 text-white p-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all active:scale-[0.98]">
                Perbarui Password
            </button>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 font-semibold hover:underline">
                    Kembali ke Halaman Login
                </a>
            </div>
        </form>
    </div>
</body>
</html>