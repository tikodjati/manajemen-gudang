<body class="bg-slate-50 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Antrean Pengiriman Barang (Gudang)</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 font-bold">LOGOUT</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left">
                <thead class="bg-slate-800 text-white text-xs uppercase">
                    <tr>
                        <th class="p-4">ID Order</th>
                        <th class="p-4">Sales</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr>
                        <td class="p-4 font-mono text-blue-600">{{ $order->order_id }}</td>
                        <td class="p-4 text-slate-700">{{ $order->user->nama }}</td>
                        <td class="p-4 text-center">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-orange-600">
                                PROSES DELIVERY
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-500 italic">Belum ada antrean pengiriman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>