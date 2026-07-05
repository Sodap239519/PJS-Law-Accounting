<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    /**
     * เมนูหน้าเว็บสาธารณะเริ่มต้น (key ตรงกับ route หน้าเว็บ)
     */
    public const DEFAULTS = [
        ['key' => 'home', 'label' => 'หน้าแรก', 'route' => 'home', 'visible' => true],
        ['key' => 'about', 'label' => 'เกี่ยวกับเรา', 'route' => 'about.index', 'visible' => true],
        ['key' => 'services', 'label' => 'บริการของเรา', 'route' => 'services.index', 'visible' => true],
        ['key' => 'team', 'label' => 'ทีมงาน', 'route' => 'team.index', 'visible' => true],
        ['key' => 'news', 'label' => 'ข่าวสารและกิจกรรม', 'route' => 'news.index', 'visible' => true],
        ['key' => 'cases', 'label' => 'คดีตัวอย่าง', 'route' => 'cases.index', 'visible' => true],
        ['key' => 'downloads', 'label' => 'เอกสารดาวน์โหลด', 'route' => 'documents.index', 'visible' => true],
        ['key' => 'contact', 'label' => 'ติดต่อเรา', 'route' => 'contact.index', 'visible' => true],
    ];

    public function edit(): Response
    {
        return Inertia::render('Admin/Menus/Edit', [
            'items' => $this->resolved(),
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
        $byKey = collect(self::DEFAULTS)->keyBy('key');
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

    /**
     * รวมค่าที่บันทึกไว้กับค่าเริ่มต้น โดยคงลำดับที่ผู้ใช้จัดไว้
     * แล้วต่อท้ายด้วยเมนูใหม่ที่เพิ่งเพิ่มในโค้ด (ยังไม่เคยบันทึก)
     */
    private function resolved(): array
    {
        $defByKey = collect(self::DEFAULTS)->keyBy('key');
        $saved = collect(json_decode((string) Setting::get('public_menu', ''), true) ?: []);

        $ordered = $saved
            ->filter(fn ($i) => isset($i['key']) && $defByKey->has($i['key']))
            ->map(fn ($i) => array_merge($defByKey[$i['key']], [
                'label' => $i['label'] ?? $defByKey[$i['key']]['label'],
                'visible' => (bool) ($i['visible'] ?? true),
            ]))
            ->values();

        $seen = $ordered->pluck('key');
        $missing = collect(self::DEFAULTS)->reject(fn ($d) => $seen->contains($d['key']))->values();

        return $ordered->concat($missing)->values()->all();
    }
}
