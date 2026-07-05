<?php

namespace Tests\Feature\Admin;

use App\Models\Banner;
use App\Models\ContactChannel;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Phase2ModulesTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    private function superAdmin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);
    }

    public function test_admin_can_reach_phase2_index_pages(): void
    {
        $admin = $this->admin();

        foreach (['banners', 'team-members', 'contact-channels', 'documents'] as $slug) {
            $this->actingAs($admin)->get("/admin/{$slug}")->assertOk();
        }

        $this->actingAs($admin)->get('/admin/settings')->assertOk();
        $this->actingAs($admin)->get('/admin/about')->assertOk();
    }

    public function test_banner_create_and_reorder(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/banners', [
            'title' => 'แบนเนอร์ทดสอบ', 'is_active' => true,
        ])->assertRedirect(route('admin.banners.index'));

        $a = Banner::create(['title' => 'A', 'sort_order' => 1, 'is_active' => true]);
        $b = Banner::create(['title' => 'B', 'sort_order' => 2, 'is_active' => true]);

        $this->actingAs($admin)->post('/admin/banners/reorder', ['ids' => [$b->id, $a->id]])->assertRedirect();
        $this->assertSame(1, $b->fresh()->sort_order);
        $this->assertSame(2, $a->fresh()->sort_order);
    }

    public function test_team_member_requires_name_and_position(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/team-members', ['name' => ''])
            ->assertSessionHasErrors(['name', 'position']);
    }

    public function test_team_member_stores_socials_as_array(): void
    {
        $this->actingAs($this->admin())->post('/admin/team-members', [
            'name' => 'ทนาย ก', 'position' => 'หุ้นส่วน', 'is_active' => true,
            'socials' => ['line' => '@pjs', 'facebook' => '', 'email' => 'a@b.c', 'phone' => ''],
        ])->assertRedirect(route('admin.team-members.index'));

        $m = TeamMember::first();
        $this->assertSame(['line' => '@pjs', 'email' => 'a@b.c'], $m->socials);
    }

    public function test_contact_channel_type_validated(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/contact-channels', ['type' => 'bogus', 'value' => 'x'])
            ->assertSessionHasErrors('type');

        $this->actingAs($this->admin())->post('/admin/contact-channels', [
            'type' => 'phone', 'value' => '021234567', 'is_active' => true,
        ])->assertRedirect(route('admin.contact-channels.index'));

        // ไอคอนเริ่มต้นถูกเติมให้อัตโนมัติ
        $this->assertSame('bi bi-telephone', ContactChannel::first()->icon);
    }

    public function test_settings_update_saves_values(): void
    {
        $this->actingAs($this->admin())->put('/admin/settings', [
            'site_name' => 'PJS ใหม่', 'tagline' => 'ครบวงจร',
        ])->assertRedirect();

        $this->assertSame('PJS ใหม่', Setting::get('site_name'));
        $this->assertSame('ครบวงจร', Setting::get('tagline'));
    }

    public function test_menu_update_persists_order_and_visibility(): void
    {
        $this->actingAs($this->superAdmin())->put('/admin/menus', [
            'items' => [
                ['key' => 'contact', 'label' => 'ติดต่อเรา', 'visible' => true],
                ['key' => 'home', 'label' => 'หน้าหลัก', 'visible' => false],
            ],
        ])->assertRedirect();

        $saved = json_decode(Setting::get('public_menu'), true);
        $this->assertSame('contact', $saved[0]['key']);
        $this->assertSame('หน้าหลัก', $saved[1]['label']);
        $this->assertFalse($saved[1]['visible']);
    }

    public function test_super_admin_only_areas_blocked_for_admin(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get('/admin/users')->assertForbidden();
        $this->actingAs($admin)->get('/admin/menus')->assertForbidden();
    }

    public function test_super_admin_can_manage_users(): void
    {
        $this->actingAs($this->superAdmin())->post('/admin/users', [
            'name' => 'ผู้ใช้ใหม่', 'email' => 'new@pjs.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'role' => User::ROLE_ADMIN,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'new@pjs.com', 'role' => User::ROLE_ADMIN]);
    }

    public function test_super_admin_cannot_delete_self(): void
    {
        $super = $this->superAdmin();
        $this->actingAs($super)->delete("/admin/users/{$super->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $super->id]);
    }
}
