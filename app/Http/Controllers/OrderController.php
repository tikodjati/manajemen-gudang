<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        return view('sales.order_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama_item.*' => 'required',
            'qty.*' => 'required|integer|min:1',
            'harga.*' => 'required|numeric',
        ]);

        // 1. Upload Bukti Pembayaran
        $file = $request->file('bukti_pembayaran');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti_bayar', $nama_file);

        // 2. Simpan Data Order (Header)
        $order = Order::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'total_harga' => 0, // Akan diupdate setelah item dihitung
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => $nama_file,
        ]);

        // 3. Simpan Detail Item & Hitung Total
        $total = 0;
        foreach ($request->nama_item as $key => $val) {
            $subtotal = $request->qty[$key] * $request->harga[$key];
            OrderItem::create([
                'order_id' => $order->id,
                'nama_item' => $request->nama_item[$key],
                'qty' => $request->qty[$key],
                'harga' => $request->harga[$key],
            ]);
            $total += $subtotal;
        }

        // 4. Update Total Harga di Order
        $order->update(['total_harga' => $total]);

        return redirect('/sales/dashboard')->with('success', 'Orderan berhasil dikirim!');
    }
}