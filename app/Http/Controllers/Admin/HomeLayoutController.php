<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
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
                'news' => News::published()
                    ->orderBy('published_at', 'desc')
                    ->get(['id', 'title', 'published_at'])
                    ->map(fn ($n) => [
                        'id' => $n->id,
                        'title' => $n->title,
                        'date' => optional($n->published_at)->format('d/m/Y'),
                    ]),
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
