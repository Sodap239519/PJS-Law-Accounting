<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AboutPageController extends Controller
{
    /** ตำแหน่งรูปในแต่ละ section */
    public const POSITIONS = [
        'left' => 'รูปซ้าย + ข้อความขวา',
        'right' => 'รูปขวา + ข้อความซ้าย',
        'full' => 'ข้อความเต็มความกว้าง (ไม่มีรูป)',
    ];

    public function edit(): Response
    {
        $about = AboutPage::singleton();

        return Inertia::render('Admin/About/Edit', [
            'about' => [
                'intro_title' => $about->intro_title,
                'intro_subtitle' => $about->intro_subtitle,
                'vision' => $about->vision,
                'mission' => $about->mission,
                'sections' => $about->sections ?: [],
            ],
            'positions' => self::POSITIONS,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'intro_title' => ['nullable', 'string', 'max:255'],
            'intro_subtitle' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*.icon' => ['nullable', 'string', 'max:100'],
            'sections.*.heading' => ['nullable', 'string', 'max:255'],
            'sections.*.content' => ['nullable', 'string'],
            'sections.*.image' => ['nullable', 'string', 'max:1000'],
            'sections.*.position' => ['nullable', 'string', 'in:'.implode(',', array_keys(self::POSITIONS))],
        ]);

        // เก็บเฉพาะ section ที่มีหัวข้อหรือเนื้อหา
        $sections = collect($data['sections'] ?? [])
            ->filter(fn ($s) => ! empty($s['heading']) || ! empty($s['content']) || ! empty($s['image']))
            ->map(fn ($s) => [
                'icon' => $s['icon'] ?? '',
                'heading' => $s['heading'] ?? '',
                'content' => $s['content'] ?? '',
                'image' => $s['image'] ?? '',
                'position' => $s['position'] ?? 'left',
            ])
            ->values()
            ->all();

        AboutPage::singleton()->update([
            'intro_title' => $data['intro_title'] ?? null,
            'intro_subtitle' => $data['intro_subtitle'] ?? null,
            'vision' => $data['vision'] ?? null,
            'mission' => $data['mission'] ?? null,
            'sections' => $sections,
        ]);

        return back()->with('success', 'บันทึกหน้าเกี่ยวกับเราเรียบร้อยแล้ว');
    }
}
