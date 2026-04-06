<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Mengosongkan DB setiap kali test jalan

    /** @test */
    public function user_can_access_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function sales_can_login_and_access_sales_dashboard()
    {
        $user = User::factory()->create(['role' => 'sales', 'nama' => 'Sales Test']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Default factory password
            'role' => 'sales',
        ]);

        $response->assertRedirect('/sales/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function sales_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'sales']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Sesuai PBI-003, harus diredirect balik dengan pesan error 
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}