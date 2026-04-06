<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sales_can_submit_order_with_items_and_evidence()
    {

        Storage::fake('public');

        $sales = User::factory()->create(['role' => 'sales']);



        $orderData = [

            'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),

            'nama_item' => ['Barang A', 'Barang B'],

            'qty' => [2, 3],

            'harga' => [10000, 20000],

        ];



        $response = $this->actingAs($sales)->post('/sales/order/store', $orderData);



        $response->assertRedirect('/sales/dashboard');



        // Pastikan total harga benar: (2*10000) + (3*20000) = 80000

        $this->assertDatabaseHas('orders', [

            'total_harga' => 80000,

        ]);



        $order = Order::first();

        // Cek keberadaan file di disk public

        $this->assertTrue(Storage::disk('public')->exists('bukti_bayar/' . $order->bukti_pembayaran));
    }
}
