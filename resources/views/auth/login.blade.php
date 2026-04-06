<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    <title>Login - Sistem Order & Gudang</title>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8 m-4">
        <div class="text-center mb-8">
            <div class="bg-slate-800 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-white text-3xl">📦</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Sistem Order & Gudang</h2>
            <p class="text-slate-500 text-sm">Manajemen Order & Pengiriman</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-slate-700 font-semibold mb-2">Pilih Role Anda</label>
                <select name="role" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="sales">Sales</option>
                    <option value="admin">Admin</option>
                    <option value="kepala_gudang">Kepala Gudang</option>
                </select>
            </div>

            <div class="mb-4">
                <input type="email" name="email" placeholder="Email Address" class="w-full p-3 rounded-xl bg-slate-100 border-none outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded-xl bg-slate-100 border-none outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-xl font-bold hover:bg-blue-700 transition">
                Masuk ke Dashboard
            </button>
        </form>
    </div>
</body>
</html>