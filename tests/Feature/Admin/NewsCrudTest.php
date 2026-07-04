<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    public function test_guest_cannot_access_admin_news(): void
    {
        $this->get('/admin/news')->assertRedirect('/login');
    }

    public function test_admin_can_view_index(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/news')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/News/Index'));
    }

    public function test_admin_can_create_news_with_cover_and_link(): void
    {
        Storage::fake('public');
        $cat = Category::create(['name' => 'ข่าวทั่วไป', 'slug' => 'gen', 'type' => 'news', 'is_active' => true]);

        $this->actingAs($this->admin())
            ->post('/admin/news', [
                'title' => 'ข่าวทดสอบระบบ',
                'content' => '<p>เนื้อหาข่าว</p>',
                'category_id' => $cat->id,
                'is_published' => true,
                'cover' => UploadedFile::fake()->image('cover.jpg', 1600, 900),
                'links' => [['label' => 'เว็บที่เกี่ยวข้อง', 'url' => 'https://example.com']],
            ])
            ->assertRedirect(route('admin.news.index'));

        $news = News::first();
        $this->assertNotNull($news);
        $this->assertSame('ข่าวทดสอบระบบ', $news->title);
        $this->assertNotEmpty($news->slug);
        $this->assertTrue($news->is_published);
        $this->assertNotNull($news->getFirstMedia('cover'));
        $this->assertCount(1, $news->links);
    }

    public function test_validation_requires_title_and_content(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/news', ['title' => '', 'content' => ''])
            ->assertSessionHasErrors(['title', 'content']);
    }

    public function test_admin_can_edit_form(): void
    {
        $news = News::create(['title' => 'เดิม', 'slug' => 'old-slug', 'content' => 'x']);

        $this->actingAs($this->admin())
            ->get('/admin/news/'.$news->slug.'/edit')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/News/Form')->where('news.title', 'เดิม'));
    }

    public function test_admin_can_update_keeping_slug(): void
    {
        $news = News::create(['title' => 'เดิม', 'slug' => 'old-slug', 'content' => 'x', 'is_published' => false]);

        $this->actingAs($this->admin())
            ->put('/admin/news/'.$news->slug, ['title' => 'ใหม่', 'content' => 'y', 'is_published' => true])
            ->assertRedirect(route('admin.news.index'));

        $fresh = $news->fresh();
        $this->assertSame('ใหม่', $fresh->title);
        $this->assertSame('old-slug', $fresh->slug); // slug คงเดิม
        $this->assertTrue($fresh->is_published);
    }

    public function test_admin_can_save_translations(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/news', [
                'title' => 'ข่าวไทย',
                'content' => '<p>เนื้อหาไทย</p>',
                'translations' => [
                    'en' => ['title' => 'English News', 'content' => '<p>English body</p>'],
                    'zh' => ['title' => '中文新闻'],
                ],
            ])
            ->assertRedirect(route('admin.news.index'));

        $news = News::first();
        $this->assertSame('English News', $news->translations['en']['title']);
        $this->assertSame('中文新闻', $news->translations['zh']['title']);
    }

    public function test_admin_can_delete(): void
    {
        $news = News::create(['title' => 'ลบ', 'slug' => 'del', 'content' => 'x']);

        $this->actingAs($this->admin())
            ->delete('/admin/news/'.$news->slug)
            ->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseCount('news', 0);
    }
}
