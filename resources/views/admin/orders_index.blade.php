<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    <title>Rekap Orderan - Admin</title>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Perekapan Orderan Masuk</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 font-medium italic">Logout</button>
            </form>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-100 text-slate-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4 border-b">ID Order</th>
                        <th class="p-4 border-b">Nama Sales</th>
                        <th class="p-4 border-b">Total Harga</th>
                        <th class="p-4 border-b">Status</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-mono text-sm text-blue-600">{{ $order->order_id }}</td>
                        <td class="p-4 text-slate-700">{{ $order->user->nama }}</td>
                        <td class="p-4 text-slate-700 font-semibold">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $order->status == 'belum_terkonfirmasi' ? 'bg-yellow-100 text-yellow-700' : ($order->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <a href="#" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-700">
                                DETAIL
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 italic">Belum ada orderan yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>