<?php

namespace Tests\Feature\Admin;

use App\Models\Announcement;
use App\Models\CaseStudy;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * โมเดล News/Announcement/CaseStudy ผูก slug สำหรับหน้าเว็บ แต่หลังบ้านต้องเข้าถึงด้วย id
 */
class AdminSlugModelRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_edit_pages_by_id(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $news = News::create(['title' => 'n', 'slug' => 'n-slug', 'content' => 'x', 'is_published' => true]);
        $ann = Announcement::create(['title' => 'a', 'slug' => 'a-slug', 'content' => 'x', 'is_published' => true]);
        $case = CaseStudy::create(['title' => 'c', 'slug' => 'c-slug', 'content' => 'x', 'is_published' => true]);

        $this->actingAs($admin)->get("/admin/news/{$news->id}/edit")->assertOk();
        $this->actingAs($admin)->get("/admin/announcements/{$ann->id}/edit")->assertOk();
        $this->actingAs($admin)->get("/admin/case-studies/{$case->id}/edit")->assertOk();
    }

    public function test_admin_can_delete_by_id(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $news = News::create(['title' => 'n', 'slug' => 'n-slug', 'content' => 'x', 'is_published' => true]);

        $this->actingAs($admin)->delete("/admin/news/{$news->id}")->assertRedirect();
        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    }
}
