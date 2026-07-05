<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AboutPageController extends Controller
{
    use HandlesMediaAndLinks;

    /** เลย์เอาต์ที่เลือกได้ */
    public const LAYOUTS = [
        'layout1' => 'ข้อความเต็มความกว้าง (เรียบง่าย)',
        'layout2' => 'รูปซ้าย + ข้อความขวา',
        'layout3' => 'ข้อความบน + แกลเลอรีรูปด้านล่าง',
    ];

    public function edit(): Response
    {
        $about = AboutPage::singleton();

        return Inertia::render('Admin/About/Edit', [
            'about' => [
                'layout' => $about->layout,
                'content' => $about->content,
                'gallery' => $about->getMedia('gallery')->map(fn ($m) => [
                    'id' => $m->id,
                    'url' => $m->getUrl(),
                    'name' => $m->file_name,
                ])->values(),
            ],
            'layouts' => self::LAYOUTS,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'layout' => ['required', 'string', 'in:'.implode(',', array_keys(self::LAYOUTS))],
            'content' => ['nullable', 'string'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:5120'],
            'deleted_media' => ['nullable', 'array'],
        ]);

        $about = AboutPage::singleton();
        $about->update([
            'layout' => $data['layout'],
            'content' => $data['content'] ?? null,
        ]);

        $this->deleteRemovedMedia($about, $request);
        $this->addFiles($about, $request, 'gallery', 'gallery');

        return back()->with('success', 'บันทึกหน้าเกี่ยวกับเราเรียบร้อยแล้ว');
    }
}
