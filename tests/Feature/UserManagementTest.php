<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post('/users', ['name'=>'Staf Baru','email'=>'staf@example.test','role'=>'user','password'=>'password123','password_confirmation'=>'password123'])->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email'=>'staf@example.test','role'=>'user']);
    }

    public function test_regular_user_cannot_access_user_management(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get('/users/create')->assertForbidden();
    }

    public function test_admin_can_update_another_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['email' => 'before@example.test', 'role' => 'user']);

        $this->actingAs($admin)->put("/users/{$user->id}", ['name'=>'Nama Baru','email'=>'after@example.test','role'=>'admin','password'=>'','password_confirmation'=>''])->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['id'=>$user->id,'name'=>'Nama Baru','email'=>'after@example.test','role'=>'admin']);
    }

    public function test_admin_can_delete_another_user_but_not_self(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)->delete("/users/{$user->id}")->assertRedirect();
        $this->assertDatabaseMissing('users', ['id'=>$user->id]);
        $this->actingAs($admin)->delete("/users/{$admin->id}")->assertRedirect();
        $this->assertDatabaseHas('users', ['id'=>$admin->id]);
    }
}
