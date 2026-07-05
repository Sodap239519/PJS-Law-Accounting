<?php

namespace App\Support;

use App\Models\Setting;

/**
 * เมนูหน้าเว็บสาธารณะ — จัดการผ่าน admin (Setting key: public_menu)
 * ใช้ร่วมกันระหว่าง MenuController (admin) และ View Composer (หน้าเว็บ)
 */
class SiteMenu
{
    /** เมนูเริ่มต้น (key ตรงกับ route หน้าเว็บ) */
    public const DEFAULTS = [
        ['key' => 'home', 'label' => 'หน้าหลัก', 'route' => 'home', 'visible' => true],
        ['key' => 'about', 'label' => 'เกี่ยวกับเรา', 'route' => 'about.index', 'visible' => true],
        ['key' => 'services', 'label' => 'บริการ', 'route' => 'services.index', 'visible' => true],
        ['key' => 'team', 'label' => 'ทีมงาน', 'route' => 'team.index', 'visible' => true],
        ['key' => 'news', 'label' => 'ข่าวสาร', 'route' => 'news.index', 'visible' => true],
        ['key' => 'cases', 'label' => 'คดีตัวอย่าง', 'route' => 'cases.index', 'visible' => true],
        ['key' => 'downloads', 'label' => 'เอกสารดาวน์โหลด', 'route' => 'documents.index', 'visible' => true],
        ['key' => 'contact', 'label' => 'ติดต่อเรา', 'route' => 'contact.index', 'visible' => true],
    ];

    /**
     * เมนูทั้งหมด — คงลำดับที่ผู้ใช้จัดไว้ แล้วต่อท้ายด้วยเมนูใหม่ในโค้ด
     * (ใช้ในหน้า admin จัดการเมนู)
     */
    public static function all(): array
    {
        $defByKey = collect(self::DEFAULTS)->keyBy('key');
        $saved = collect(json_decode((string) Setting::get('public_menu', ''), true) ?: []);

        $ordered = $saved
            ->filter(fn ($i) => isset($i['key']) && $defByKey->has($i['key']))
            ->map(fn ($i) => array_merge($defByKey[$i['key']], [
                'label' => $i['label'] ?? $defByKey[$i['key']]['label'],
                'visible' => (bool) ($i['visible'] ?? true),
                'children' => self::cleanChildren($i['children'] ?? []),
            ]))
            ->values();

        $seen = $ordered->pluck('key');
        $missing = collect(self::DEFAULTS)
            ->reject(fn ($d) => $seen->contains($d['key']))
            ->map(fn ($d) => array_merge($d, ['children' => []]))
            ->values();

        return $ordered->concat($missing)->values()->all();
    }

    /**
     * ทำความสะอาดเมนูย่อย (เก็บเฉพาะที่มีชื่อ)
     */
    public static function cleanChildren($children): array
    {
        return collect(is_array($children) ? $children : [])
            ->filter(fn ($c) => ! empty($c['label']))
            ->map(fn ($c) => [
                'label' => $c['label'],
                'url' => $c['url'] ?? '#',
                'visible' => (bool) ($c['visible'] ?? true),
            ])
            ->values()
            ->all();
    }

    /**
     * เฉพาะเมนูที่เปิดแสดง + ผูก URL แล้ว + เมนูย่อยที่เปิดแสดง (ใช้บนหน้าเว็บสาธารณะ)
     */
    public static function visible(): array
    {
        return collect(self::all())
            ->filter(fn ($i) => $i['visible'])
            ->map(fn ($i) => [
                'key' => $i['key'],
                'label' => $i['label'],
                'url' => route($i['route']),
                'children' => collect($i['children'] ?? [])
                    ->filter(fn ($c) => $c['visible'])
                    ->map(fn ($c) => ['label' => $c['label'], 'url' => $c['url']])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }
}
