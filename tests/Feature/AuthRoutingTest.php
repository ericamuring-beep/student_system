<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_login_page(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_user_registration_creates_a_user_account(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jane User',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/students');

        $this->assertDatabaseHas('users', [
            'name' => 'Jane User',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_user_login_redirects_to_user_dashboard(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'identifier' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/students');
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'identifier' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/students');
    }

    public function test_role_protected_dashboard_blocks_the_wrong_account_type(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user2@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $this->actingAs($user);

        $this->get('/admin/dashboard')->assertForbidden();
    }

    public function test_admin_students_route_redirects_to_admin_page(): void
    {
        $admin = User::create([
            'name' => 'Admin Viewer',
            'email' => 'admin-viewer@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/students');

        $response->assertRedirect('/admin/students');
    }

    public function test_user_students_route_redirects_to_user_page(): void
    {
        $user = User::create([
            'name' => 'User Viewer',
            'email' => 'user-viewer@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/students');

        $response->assertRedirect('/user/students');
    }

    public function test_logout_redirects_to_login_page(): void
    {
        $user = User::create([
            'name' => 'Logout User',
            'email' => 'logout@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}