<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    <title>Gudang - Delivery Order</title>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Antrean Pengiriman Barang (Gudang)</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 font-bold hover:underline uppercase text-sm tracking-tight">LOGOUT</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left">
                <thead class="bg-slate-800 text-white text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4">ID Order</th>
                        <th class="p-4">Nama Sales</th>
                        <th class="p-4 text-center w-1/3">Input No. Resi / Surat Jalan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono text-blue-600 font-semibold">{{ $order->order_id }}</td>
                            <td class="p-4 text-slate-700 font-medium">{{ $order->user->nama }}</td>
                            <td class="p-4">
                                @if(!$order->no_resi)
                                    <form action="{{ route('gudang.order.resi', $order->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="no_resi" 
                                               placeholder="Ketik No. Resi di sini..." 
                                               class="border-slate-200 rounded-lg text-xs w-full focus:ring-orange-500 focus:border-orange-500" 
                                               required>
                                        <button type="submit" 
                                                class="bg-orange-500 text-white px-4 py-2 rounded-lg text-[10px] font-black hover:bg-orange-600 transition shadow-sm whitespace-nowrap">
                                            KIRIM BARANG
                                        </button>
                                    </form>
                                @else
                                    <div class="flex flex-col items-center">
                                        <span class="text-green-600 font-bold text-[10px] uppercase tracking-tighter">✅ Sudah Terkirim</span>
                                        <p class="text-[11px] text-slate-500 font-mono bg-slate-100 px-2 py-0.5 rounded">{{ $order->no_resi }}</p>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center text-slate-500 italic">
                                <div class="flex flex-col items-center justify-center opacity-60">
                                    <span class="text-4xl mb-2">📦</span>
                                    <p>Belum ada antrean pengiriman yang disetujui Admin.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>