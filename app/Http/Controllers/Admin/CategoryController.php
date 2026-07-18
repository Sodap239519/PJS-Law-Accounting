<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public const TYPES = [
        'news' => 'ข่าวสาร',
        'announcement' => 'ประชาสัมพันธ์',
        'case_study' => 'คดีตัวอย่าง',
        'document' => 'เอกสารดาวน์โหลด',
    ];

    public function index(): Response
    {
        $categories = Category::orderBy('name')->get(['id', 'name', 'type', 'is_active'])
            ->groupBy('type');

        return Inertia::render('Admin/Categories/Index', [
            'types' => self::TYPES,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(array_keys(self::TYPES))],
        ]);

        Category::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'slug' => $this->slug($data['name']),
            'is_active' => true,
        ]);

        return back()->with('success', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $category->update([
            'name' => $data['name'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'อัปเดตหมวดหมู่เรียบร้อยแล้ว');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }

    private function slug(string $name): string
    {
        $base = Str::slug($name);

        return ($base !== '' ? $base : 'category').'-'.Str::lower(Str::random(6));
    }
}
