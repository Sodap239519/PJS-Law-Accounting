<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\Announcement;
use App\Models\CaseStudy;
use App\Models\News;
use App\Models\TeamMember;
use App\Support\HomeLayout;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeLayoutController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/HomeLayout/Edit', [
            'sections' => HomeLayout::items(),
            // รายการที่เลือกได้ต่อ section
            'available' => [
                'about' => collect(AboutPage::singleton()->sections ?? [])
                    ->values()
                    ->map(fn ($s, $i) => [
                        'id' => $i + 1, // 1-based (กัน save() กรอง 0 ทิ้ง)
                        'title' => $s['heading'] ?? ('บล็อกที่ '.($i + 1)),
                        'date' => match ($s['position'] ?? 'left') {
                            'full' => 'เต็มความกว้าง',
                            'right' => 'รูปขวา',
                            default => 'รูปซ้าย',
                        },
                    ]),
                'news' => News::published()
                    ->orderBy('published_at', 'desc')
                    ->get(['id', 'title', 'published_at'])
                    ->map(fn ($n) => [
                        'id' => $n->id,
                        'title' => $n->title,
                        'date' => optional($n->published_at)->format('d/m/Y'),
                    ]),
                'announcement' => Announcement::published()
                    ->orderBy('published_at', 'desc')
                    ->get(['id', 'title', 'published_at'])
                    ->map(fn ($a) => ['id' => $a->id, 'title' => $a->title, 'date' => optional($a->published_at)->format('d/m/Y')]),
                'cases' => CaseStudy::published()
                    ->latest()
                    ->get(['id', 'title', 'client_name'])
                    ->map(fn ($c) => ['id' => $c->id, 'title' => $c->title, 'date' => $c->client_name]),
                'team' => TeamMember::where('is_active', true)
                    ->orderBy('order')
                    ->get(['id', 'name', 'position'])
                    ->map(fn ($m) => ['id' => $m->id, 'title' => $m->name, 'date' => $m->position]),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.key' => ['required', 'string'],
            'sections.*.visible' => ['boolean'],
            'sections.*.mode' => ['nullable', 'in:latest,selected'],
            'sections.*.items' => ['nullable', 'array'],
            'sections.*.items.*' => ['integer'],
        ]);

        HomeLayout::save($data['sections']);

        return back()->with('success', 'บันทึกการจัดการหน้าแรกเรียบร้อยแล้ว');
    }
}
