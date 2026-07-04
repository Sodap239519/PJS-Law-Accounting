<?php

namespace Tests\Feature\Admin;

use App\Models\Announcement;
use App\Models\CaseStudy;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentModulesTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    public function test_announcement_index_and_create_with_cover(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin())
            ->get('/admin/announcements')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Announcements/Index'));

        $this->actingAs($this->admin())
            ->post('/admin/announcements', [
                'title' => 'ประกาศทดสอบ',
                'content' => '<p>เนื้อหา</p>',
                'is_published' => true,
                'cover' => UploadedFile::fake()->image('c.jpg', 800, 1000),
            ])
            ->assertRedirect(route('admin.announcements.index'));

        $a = Announcement::first();
        $this->assertNotNull($a);
        $this->assertNotEmpty($a->slug);
        $this->assertNotNull($a->getFirstMedia('cover'));
    }

    public function test_case_study_create_without_cover(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/case-studies', [
                'title' => 'คดีทดสอบ',
                'client_name' => 'บริษัทเอกชน',
                'content' => '<p>รายละเอียด</p>',
                'is_published' => true,
            ])
            ->assertRedirect(route('admin.case-studies.index'));

        $c = CaseStudy::first();
        $this->assertSame('คดีทดสอบ', $c->title);
        $this->assertSame('บริษัทเอกชน', $c->client_name);
        $this->assertNotEmpty($c->slug);
    }

    public function test_service_crud(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/services')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Services/Index'));

        $this->actingAs($this->admin())
            ->post('/admin/services', [
                'title' => 'บริการที่ปรึกษากฎหมาย',
                'icon' => 'bi bi-briefcase',
                'content' => '<p>บริการครบวงจร</p>',
                'sort_order' => 1,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.services.index'));

        $s = Service::first();
        $this->assertSame('บริการที่ปรึกษากฎหมาย', $s->title);
        $this->assertTrue($s->is_active);

        $this->actingAs($this->admin())
            ->delete('/admin/services/'.$s->id)
            ->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseCount('services', 0);
    }

    public function test_title_required_across_modules(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post('/admin/announcements', ['title' => ''])->assertSessionHasErrors('title');
        $this->actingAs($admin)->post('/admin/case-studies', ['title' => ''])->assertSessionHasErrors('title');
        $this->actingAs($admin)->post('/admin/services', ['title' => ''])->assertSessionHasErrors('title');
    }
}
