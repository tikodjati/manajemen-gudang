<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Menampilkan form input orderan (PBI-008)
     */
    public function create()
    {
        return view('sales.order_create');
    }

    /**
     * Menyimpan data orderan dan detail item (PBI-008 & FR-004)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama_item.*' => 'required|string',
            'qty.*' => 'required|integer|min:1',
            'harga.*' => 'required|numeric|min:0',
        ]);

        // 1. Upload Bukti Pembayaran
        // Simpan ke disk 'public' di dalam folder 'bukti_bayar'
        $file = $request->file('bukti_pembayaran');
        $nama_file = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('bukti_bayar', $nama_file, 'public');

        // 2. Simpan Data Order (Header)
        $order = Order::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'total_harga' => 0, // Placeholder, diupdate setelah loop
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => $nama_file,
        ]);

        // 3. Simpan Detail Item & Hitung Total
        $totalHarga = 0;
        foreach ($request->nama_item as $key => $val) {
            $subtotal = $request->qty[$key] * $request->harga[$key];

            OrderItem::create([
                'order_id' => $order->id,
                'nama_item' => $request->nama_item[$key],
                'qty' => $request->qty[$key],
                'harga' => $request->harga[$key],
            ]);

            $totalHarga += $subtotal;
        }

        // 4. Update Total Harga Final di Tabel Orders
        $order->update(['total_harga' => $totalHarga]);

        return redirect('/sales/dashboard')->with('success', 'Orderan ' . $order->order_id . ' berhasil dikirim!');
    }

    public function index()
    {
        // Mengambil semua orderan beserta data sales (user) dan itemnya
        $orders = Order::with('user', 'items')->latest()->get();
        return view('admin.orders_index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);

        $pesan = $request->status == 'diterima' ? 'Orderan berhasil diterima!' : 'Orderan telah ditolak.';

        return redirect()->back()->with('success', $pesan);
    }

    public function gudangIndex()
    {
        // Hanya mengambil orderan yang sudah dikonfirmasi 'diterima' oleh Admin
        $orders = Order::with('user')
            ->where('status', 'diterima')
            ->latest()
            ->get();

        return view('gudang.dashboard', compact('orders'));
    }
}
