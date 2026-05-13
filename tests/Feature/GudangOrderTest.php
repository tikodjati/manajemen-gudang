<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GudangOrderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function warehouse_head_can_see_accepted_orders_only()
    {
        $gudang = User::factory()->create(['role' => 'kepala_gudang']);
        $sales = User::factory()->create(['role' => 'sales']);
        
        // Order 1: Sudah Diterima (Harus Muncul)
        Order::create([
            'order_id' => 'ORD-GUDANG01',
            'user_id' => $sales->id,
            'total_harga' => 50000,
            'status' => 'diterima',
            'bukti_pembayaran' => 'test.jpg'
        ]);

        // Order 2: Belum Terkonfirmasi (Tidak Boleh Muncul)
        Order::create([
            'order_id' => 'ORD-PENDING01',
            'user_id' => $sales->id,
            'total_harga' => 30000,
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => 'test2.jpg'
        ]);

        $response = $this->actingAs($gudang)->get('/gudang/dashboard');

        $response->assertStatus(200);
        $response->assertSee('ORD-GUDANG01');
        $response->assertDontSee('ORD-PENDING01');
    }

    #[Test]
    public function warehouse_head_can_input_tracking_number()
    {
        $gudang = User::factory()->create(['role' => 'kepala_gudang']);
        $order = Order::create([
            'order_id' => 'ORD-RESI01',
            'user_id' => User::factory()->create()->id,
            'total_harga' => 25000,
            'status' => 'diterima',
            'bukti_pembayaran' => 'test.jpg'
        ]);

        $response = $this->actingAs($gudang)->post("/gudang/order/{$order->id}/resi", [
            'no_resi' => 'RESI123456789'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'no_resi' => 'RESI123456789'
        ]);
    }

    #[Test]
    public function unauthorized_user_cannot_input_tracking_number()
    {
        $sales = User::factory()->create(['role' => 'sales']);
        $order = Order::create([
            'order_id' => 'ORD-RESI-SAFE',
            'user_id' => $sales->id,
            'total_harga' => 10000,
            'status' => 'diterima',
            'bukti_pembayaran' => 'test.jpg'
        ]);

        // Sales mencoba nembak route gudang
        $response = $this->actingAs($sales)->post("/gudang/order/{$order->id}/resi", [
            'no_resi' => 'RESI-HACKED'
        ]);

        $response->assertRedirect('/login'); // Mental karena middleware role
        $this->assertDatabaseMissing('orders', [
            'no_resi' => 'RESI-HACKED'
        ]);
    }
}