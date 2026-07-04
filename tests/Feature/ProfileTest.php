<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    public function test_profile_page_is_displayed(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/profile')
            ->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = $this->admin();

        $this->actingAs($user)
            ->patch('/admin/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin/profile');

        $user->refresh();
        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = $this->admin();

        $this->actingAs($user)
            ->patch('/admin/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_upload_avatar(): void
    {
        Storage::fake('public');
        $user = $this->admin();

        $this->actingAs($user)
            ->patch('/admin/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => UploadedFile::fake()->image('me.jpg', 300, 300),
            ])
            ->assertSessionHasNoErrors();

        $this->assertNotNull($user->fresh()->getFirstMedia('avatar'));
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = $this->admin();

        $this->actingAs($user)
            ->delete('/admin/profile', ['password' => 'password'])
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = $this->admin();

        $this->actingAs($user)
            ->from('/admin/profile')
            ->delete('/admin/profile', ['password' => 'wrong-password'])
            ->assertSessionHasErrors('password')
            ->assertRedirect('/admin/profile');

        $this->assertNotNull($user->fresh());
    }
}
