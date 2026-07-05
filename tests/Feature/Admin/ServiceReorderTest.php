<?php

namespace Tests\Feature\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_reorder_updates_sort_order(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $a = Service::create(['title' => 'A', 'sort_order' => 1, 'is_active' => true]);
        $b = Service::create(['title' => 'B', 'sort_order' => 2, 'is_active' => true]);
        $c = Service::create(['title' => 'C', 'sort_order' => 3, 'is_active' => true]);

        // ย้าย C ขึ้นหน้าสุด: [c, a, b]
        $this->actingAs($admin)
            ->post('/admin/services/reorder', ['ids' => [$c->id, $a->id, $b->id]])
            ->assertRedirect();

        $this->assertSame(1, $c->fresh()->sort_order);
        $this->assertSame(2, $a->fresh()->sort_order);
        $this->assertSame(3, $b->fresh()->sort_order);
    }

    public function test_reorder_rejects_unknown_id(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        Service::create(['title' => 'A', 'sort_order' => 1, 'is_active' => true]);

        $this->actingAs($admin)
            ->post('/admin/services/reorder', ['ids' => [999999]])
            ->assertSessionHasErrors('ids.0');
    }
}
