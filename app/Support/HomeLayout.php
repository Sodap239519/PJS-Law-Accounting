<?php

namespace App\Support;

use App\Models\News;
use App\Models\Setting;

class HomeLayout
{
    /** section หน้าแรกทั้งหมด (คีย์ => ชื่อ + ไอคอน) ตามลำดับเริ่มต้น */
    public const SECTIONS = [
        'hero' => ['label' => 'แบนเนอร์ (Hero)', 'icon' => 'bi bi-image'],
        'about' => ['label' => 'เกี่ยวกับเรา', 'icon' => 'bi bi-info-circle'],
        'vision' => ['label' => 'วิสัยทัศน์', 'icon' => 'bi bi-eye'],
        'team' => ['label' => 'ทีมงาน / บุคลากร', 'icon' => 'bi bi-people'],
        'cases' => ['label' => 'คดีตัวอย่าง', 'icon' => 'bi bi-bank'],
        'news' => ['label' => 'ข่าวสารและกิจกรรม', 'icon' => 'bi bi-newspaper'],
        'contact' => ['label' => 'ช่องทางการติดต่อ', 'icon' => 'bi bi-telephone'],
        'quick_contact' => ['label' => 'ปรึกษาคดีด่วน', 'icon' => 'bi bi-chat-dots'],
        'cta' => ['label' => 'แบนเนอร์ปิดท้าย (Call to Action)', 'icon' => 'bi bi-megaphone'],
    ];

    /** section ที่เลือกได้ว่าจะแสดงรายการไหน (คีย์ => จำนวนที่แสดง) */
    public const SELECTABLE = [
        'news' => 3,
    ];

    /** config ดิบที่บันทึกไว้ (map key => [visible, mode, items]) */
    private static function saved(): array
    {
        $saved = json_decode(Setting::get('home_sections', ''), true);
        $saved = is_array($saved) ? $saved : [];
        $map = [];
        $order = [];
        foreach ($saved as $s) {
            $k = $s['key'] ?? null;
            if ($k && isset(self::SECTIONS[$k]) && ! isset($map[$k])) {
                $map[$k] = $s;
                $order[] = $k;
            }
        }

        return ['map' => $map, 'order' => $order];
    }

    /** รายการ section ตามลำดับ (เติม section ใหม่ต่อท้าย): [{key,label,icon,visible,selectable,mode,items}] */
    public static function items(): array
    {
        ['map' => $map, 'order' => $order] = self::saved();

        // section ใหม่ที่ยังไม่เคยบันทึก → ต่อท้าย
        $keys = $order;
        foreach (array_keys(self::SECTIONS) as $k) {
            if (! in_array($k, $keys, true)) {
                $keys[] = $k;
            }
        }

        $items = [];
        foreach ($keys as $k) {
            $meta = self::SECTIONS[$k];
            $s = $map[$k] ?? [];
            $row = [
                'key' => $k,
                'label' => $meta['label'],
                'icon' => $meta['icon'],
                'visible' => (bool) ($s['visible'] ?? true),
                'selectable' => isset(self::SELECTABLE[$k]),
            ];
            if ($row['selectable']) {
                $row['mode'] = ($s['mode'] ?? 'latest') === 'selected' ? 'selected' : 'latest';
                $row['items'] = array_values(array_filter(array_map('intval', $s['items'] ?? [])));
            }
            $items[] = $row;
        }

        return $items;
    }

    /** map สำหรับ blade: key => ['visible'=>bool, 'order'=>int] */
    public static function map(): array
    {
        $map = [];
        foreach (self::items() as $i => $it) {
            $map[$it['key']] = ['visible' => $it['visible'], 'order' => $i];
        }

        return $map;
    }

    /** config เฉพาะ section */
    private static function config(string $key): array
    {
        foreach (self::items() as $it) {
            if ($it['key'] === $key) {
                return $it;
            }
        }

        return [];
    }

    /** บันทึกลำดับ + การแสดงผล + การเลือกรายการ */
    public static function save(array $sections): void
    {
        $clean = [];
        foreach ($sections as $s) {
            $k = $s['key'] ?? null;
            if (! $k || ! isset(self::SECTIONS[$k])) {
                continue;
            }
            $row = ['key' => $k, 'visible' => (bool) ($s['visible'] ?? true)];
            if (isset(self::SELECTABLE[$k])) {
                $row['mode'] = ($s['mode'] ?? 'latest') === 'selected' ? 'selected' : 'latest';
                $row['items'] = array_values(array_filter(array_map('intval', $s['items'] ?? [])));
            }
            $clean[] = $row;
        }
        Setting::set('home_sections', json_encode($clean, JSON_UNESCAPED_UNICODE), 'home');
    }

    /** ข่าวที่จะแสดงหน้าแรก (ตามที่เลือก หรือ ล่าสุด) */
    public static function featuredNews(?int $limit = null)
    {
        $limit ??= self::SELECTABLE['news'];
        $cfg = self::config('news');

        if (($cfg['mode'] ?? 'latest') === 'selected' && ! empty($cfg['items'])) {
            $ids = $cfg['items'];
            $items = News::published()->with('category')->whereIn('id', $ids)->get();

            return $items->sortBy(fn ($n) => array_search($n->id, $ids))->values();
        }

        return News::published()->with('category')->orderBy('published_at', 'desc')->limit($limit)->get();
    }
}
