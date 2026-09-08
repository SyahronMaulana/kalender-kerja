<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScheduleAccessTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/schedules/create');
        $response->assertForbidden();
    }

    public function test_admin_can_create_schedule(): void
    {
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $division = \App\Models\Division::create(['name'=>'Security','code'=>'SEC','color'=>'#B88732']);
        $this->actingAs($admin)->post('/schedules', ['division_id'=>$division->id,'title'=>'Test shift','schedule_date'=>'2026-09-08','start_time'=>'08:00','end_time'=>'10:00','status'=>'scheduled'])->assertRedirect('/schedules');
        $this->assertDatabaseHas('schedules', ['title'=>'Test shift','created_by'=>$admin->id]);
    }

    public function test_admin_can_open_schedule_form(): void
    {
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        \App\Models\Division::create(['name'=>'Control Room','code'=>'CR','color'=>'#F4D35E']);
        $this->actingAs($admin)->get('/schedules/create')->assertOk()->assertSee('Buat Jadwal');
    }

    public function test_admin_can_update_a_schedule_stored_with_seconds(): void
    {
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $division = \App\Models\Division::create(['name'=>'Compliance','code'=>'CMP','color'=>'#16E20C']);
        $schedule = \App\Models\Schedule::create(['division_id'=>$division->id,'title'=>'Lama','schedule_date'=>'2026-09-08','start_time'=>'04:01:00','end_time'=>'05:01:00','status'=>'scheduled','created_by'=>$admin->id]);
        $this->actingAs($admin)->put("/schedules/{$schedule->id}", ['division_id'=>$division->id,'title'=>'Baru','schedule_date'=>'2026-09-08','start_time'=>'04:01:00','end_time'=>'05:01:00','status'=>'scheduled'])->assertRedirect('/schedules');
        $this->assertDatabaseHas('schedules', ['id'=>$schedule->id,'title'=>'Baru']);
    }
}
