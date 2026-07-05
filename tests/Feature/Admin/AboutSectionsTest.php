<?php
namespace Tests\Feature\Admin;
use App\Models\AboutPage; use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class AboutSectionsTest extends TestCase {
  use RefreshDatabase;
  public function test_about_sections_save_and_render(): void {
    $admin = User::factory()->create(['role'=>User::ROLE_ADMIN]);
    $this->actingAs($admin)->put('/admin/about', [
      'intro_title'=>'บริษัททดสอบ','intro_subtitle'=>'คำโปรย',
      'vision'=>'วิสัยทัศน์ทดสอบ','mission'=>'พันธกิจทดสอบ',
      'sections'=>[
        ['icon'=>'bi bi-briefcase','heading'=>'ด้านกฎหมาย','content'=>'<p>เนื้อหากฎหมาย</p>','image'=>'/storage/x.jpg','position'=>'right'],
        ['heading'=>'','content'=>'','image'=>''], // ว่าง -> ถูกตัด
      ],
    ])->assertRedirect();

    $about = AboutPage::singleton()->fresh();
    $this->assertSame('บริษัททดสอบ', $about->intro_title);
    $this->assertCount(1, $about->sections); // section ว่างถูกตัด
    $this->assertSame('ด้านกฎหมาย', $about->sections[0]['heading']);
    $this->assertSame('right', $about->sections[0]['position']);

    // หน้าเว็บแสดง section จริง
    $this->get('/about')->assertOk()->assertSee('ด้านกฎหมาย')->assertSee('วิสัยทัศน์ทดสอบ');
  }
}
