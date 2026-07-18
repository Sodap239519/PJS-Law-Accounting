<?php
namespace Tests\Feature\Admin;
use App\Models\Category; use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class CategoryManageTest extends TestCase {
  use RefreshDatabase;
  private function admin(){ return User::factory()->create(['role'=>User::ROLE_ADMIN]); }
  public function test_index_ok(){ $this->actingAs($this->admin())->get('/admin/categories')->assertOk()->assertInertia(fn($p)=>$p->component('Admin/Categories/Index')); }
  public function test_add_edit_delete_category(){
    $admin=$this->admin();
    $this->actingAs($admin)->post('/admin/categories',['name'=>'ข่าวสารทั่วไป','type'=>'news'])->assertRedirect();
    $cat=Category::first();
    $this->assertSame('news',$cat->type); $this->assertNotEmpty($cat->slug); $this->assertTrue($cat->is_active);
    $this->actingAs($admin)->put("/admin/categories/{$cat->id}",['name'=>'ข่าวเด่น','is_active'=>false])->assertRedirect();
    $this->assertSame('ข่าวเด่น',$cat->fresh()->name); $this->assertFalse($cat->fresh()->is_active);
    $this->actingAs($admin)->delete("/admin/categories/{$cat->id}")->assertRedirect();
    $this->assertDatabaseMissing('categories',['id'=>$cat->id]);
  }
  public function test_type_validated(){
    $this->actingAs($this->admin())->post('/admin/categories',['name'=>'x','type'=>'bogus'])->assertSessionHasErrors('type');
  }
}
