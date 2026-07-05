<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\SiteMenu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Menus/Edit', [
            'items' => SiteMenu::all(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.key' => ['required', 'string'],
            'items.*.label' => ['required', 'string', 'max:100'],
            'items.*.visible' => ['boolean'],
        ]);

        // เก็บเฉพาะ key ที่รู้จัก + คงข้อมูล route เดิมไว้
        $byKey = collect(SiteMenu::DEFAULTS)->keyBy('key');
        $clean = collect($data['items'])
            ->filter(fn ($i) => $byKey->has($i['key']))
            ->map(fn ($i) => [
                'key' => $i['key'],
                'label' => $i['label'],
                'route' => $byKey[$i['key']]['route'],
                'visible' => (bool) ($i['visible'] ?? true),
            ])
            ->values()
            ->all();

        Setting::set('public_menu', json_encode($clean, JSON_UNESCAPED_UNICODE), 'menu');

        return back()->with('success', 'บันทึกเมนูเรียบร้อยแล้ว');
    }
}
