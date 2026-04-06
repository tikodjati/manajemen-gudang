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
                <button type="submit" class="text-red-600 font-medium hover:underline text-sm uppercase tracking-wider">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="p-4 border-b">ID Order</th>
                        <th class="p-4 border-b">Nama Sales</th>
                        <th class="p-4 border-b">Total Harga</th>
                        <th class="p-4 border-b">Status</th>
                        <th class="p-4 border-b text-center">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4 font-mono text-sm text-blue-600 font-semibold">{{ $order->order_id }}</td>
                        <td class="p-4 text-slate-700">{{ $order->user->nama }}</td>
                        <td class="p-4 text-slate-900 font-bold">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase
                                {{ $order->status == 'belum_terkonfirmasi' ? 'bg-yellow-100 text-yellow-700' : ($order->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                @if($order->status == 'belum_terkonfirmasi')
                                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                            TERIMA
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="bg-white border border-red-200 text-red-600 hover:bg-red-50 px-4 py-1.5 rounded-lg text-xs font-bold transition-all">
                                            TOLAK
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-xs italic font-medium">Tindakan Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 italic">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">📁</span>
                                <p>Belum ada orderan yang masuk ke sistem.</p>
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