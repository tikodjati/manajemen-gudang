<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_see_order_list_on_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $sales = User::factory()->create(['role' => 'sales']);
        
        // Buat orderan dummy
        Order::create([
            'order_id' => 'ORD-TEST01',
            'user_id' => $sales->id,
            'total_harga' => 50000,
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => 'test.jpg'
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('ORD-TEST01');
        $response->assertSee($sales->nama);
    }

    #[Test]
    public function admin_can_confirm_order_to_accepted()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::create([
            'order_id' => 'ORD-TEST02',
            'user_id' => User::factory()->create()->id,
            'total_harga' => 25000,
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => 'test2.jpg'
        ]);

        $response = $this->actingAs($admin)->post("/admin/order/{$order->id}/status", [
            'status' => 'diterima'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'diterima'
        ]);
    }

    #[Test]
    public function sales_cannot_change_order_status()
    {
        $sales = User::factory()->create(['role' => 'sales']);
        $order = Order::create([
            'order_id' => 'ORD-TEST03',
            'user_id' => $sales->id,
            'total_harga' => 10000,
            'status' => 'belum_terkonfirmasi',
            'bukti_pembayaran' => 'test3.jpg'
        ]);

        // Sales mencoba nembak route update status admin
        $response = $this->actingAs($sales)->post("/admin/order/{$order->id}/status", [
            'status' => 'diterima'
        ]);

        // Harusnya diredirect karena middleware 'role:admin'
        $response->assertRedirect('/login');
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'belum_terkonfirmasi' // Status tidak berubah
        ]);
    }
}