<?php

namespace Tests\Feature\Admin;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementSchedulingTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    public function test_future_dated_announcement_is_scheduled_not_public(): void
    {
        $future = Announcement::create([
            'title' => 'อนาคต', 'slug' => 'future', 'content' => 'x',
            'is_published' => true, 'published_at' => now()->addWeek(),
        ]);
        $past = Announcement::create([
            'title' => 'อดีต', 'slug' => 'past', 'content' => 'x',
            'is_published' => true, 'published_at' => now()->subWeek(),
        ]);

        $this->assertSame('scheduled', $future->status);
        $this->assertSame('published', $past->status);

        $publicIds = Announcement::published()->pluck('id');
        $this->assertTrue($publicIds->contains($past->id));
        $this->assertFalse($publicIds->contains($future->id));
    }

    public function test_draft_status(): void
    {
        $draft = Announcement::create(['title' => 'ร่าง', 'slug' => 'd', 'content' => 'x', 'is_published' => false]);
        $this->assertSame('draft', $draft->status);
    }

    public function test_calendar_page_renders(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/announcements/calendar')
            ->assertOk()
            ->assertInertia(fn ($p) => $p->component('Admin/Announcements/Calendar'));
    }
}
