<?php
namespace Tests\Feature\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
class EditorImageUploadTest extends TestCase {
  use RefreshDatabase;
  public function test_editor_image_upload_returns_location(): void {
    Storage::fake('public');
    $admin = User::factory()->create(['role'=>User::ROLE_ADMIN]);
    $res = $this->actingAs($admin)->postJson('/admin/editor/image', [
      'file' => UploadedFile::fake()->image('pic.jpg', 800, 600),
    ]);
    $res->assertOk()->assertJsonStructure(['location']);
    $this->assertStringContainsString('/storage/editor/', $res->json('location'));
  }
  public function test_editor_upload_rejects_non_image(): void {
    Storage::fake('public');
    $admin = User::factory()->create(['role'=>User::ROLE_ADMIN]);
    $this->actingAs($admin)->postJson('/admin/editor/image', [
      'file' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'),
    ])->assertStatus(422);
  }
}
