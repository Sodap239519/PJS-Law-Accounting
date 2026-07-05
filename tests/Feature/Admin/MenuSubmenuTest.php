<?php
namespace Tests\Feature\Admin;
use App\Models\User; use App\Support\SiteMenu;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class MenuSubmenuTest extends TestCase {
  use RefreshDatabase;
  public function test_submenu_saved_and_visible(): void {
    $super = User::factory()->create(['role'=>User::ROLE_SUPER_ADMIN]);
    $this->actingAs($super)->put('/admin/menus', ['items'=>[
      ['key'=>'services','label'=>'บริการ','visible'=>true,'children'=>[
        ['label'=>'กฎหมาย','url'=>'/services/law','visible'=>true],
        ['label'=>'ซ่อนไว้','url'=>'/x','visible'=>false],
      ]],
      ['key'=>'home','label'=>'หน้าหลัก','visible'=>true],
    ]])->assertRedirect();
    $vis = collect(SiteMenu::visible())->firstWhere('key','services');
    $this->assertCount(1, $vis['children']); // เฉพาะที่ visible
    $this->assertSame('กฎหมาย', $vis['children'][0]['label']);
    $this->assertSame('/services/law', $vis['children'][0]['url']);
  }
}
