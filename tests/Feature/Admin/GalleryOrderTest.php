<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_saved_in_dragged_order(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        // อัปโหลด 3 รูป แต่สั่งลำดับใหม่เป็น C, A, B
        $this->actingAs($admin)->post('/admin/news', [
            'title' => 'ข่าวมีแกลเลอรี', 'content' => '<p>x</p>', 'is_published' => true,
            'gallery' => [
                UploadedFile::fake()->image('a.jpg'),
                UploadedFile::fake()->image('b.jpg'),
                UploadedFile::fake()->image('c.jpg'),
            ],
            'gallery_order' => [
                ['new' => 2], // c
                ['new' => 0], // a
                ['new' => 1], // b
            ],
        ])->assertRedirect(route('admin.news.index'));

        $news = News::first();
        $names = $news->getMedia('gallery')->map(fn ($m) => $m->file_name)->all();

        $this->assertSame(['c.jpg', 'a.jpg', 'b.jpg'], $names);
    }

    public function test_reorder_existing_gallery_on_update(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $news = News::create(['title' => 'n', 'slug' => 'n', 'content' => 'x', 'is_published' => true]);
        $m1 = $news->addMedia(UploadedFile::fake()->image('one.jpg'))->toMediaCollection('gallery');
        $m2 = $news->addMedia(UploadedFile::fake()->image('two.jpg'))->toMediaCollection('gallery');

        // สลับลำดับ: two, one
        $this->actingAs($admin)->put("/admin/news/{$news->id}", [
            'title' => 'n', 'content' => 'x', 'is_published' => true,
            'gallery_order' => [['id' => $m2->id], ['id' => $m1->id]],
        ])->assertRedirect(route('admin.news.index'));

        $names = $news->fresh()->getMedia('gallery')->map(fn ($m) => $m->file_name)->all();
        $this->assertSame(['two.jpg', 'one.jpg'], $names);
    }
}
