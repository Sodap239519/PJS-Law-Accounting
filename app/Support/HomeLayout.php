<?php

namespace App\Support;

use App\Models\Announcement;
use App\Models\CaseStudy;
use App\Models\News;
use App\Models\Setting;
use App\Models\TeamMember;

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
        'announcement' => ['label' => 'ประชาสัมพันธ์', 'icon' => 'bi bi-megaphone'],
        'contact' => ['label' => 'ช่องทางการติดต่อ', 'icon' => 'bi bi-telephone'],
        'quick_contact' => ['label' => 'ปรึกษาคดีด่วน', 'icon' => 'bi bi-chat-dots'],
        'cta' => ['label' => 'แบนเนอร์ปิดท้าย (Call to Action)', 'icon' => 'bi bi-megaphone'],
    ];

    /** section ที่เลือกได้ว่าจะแสดงรายการไหน (คีย์ => จำนวนที่แสดงเริ่มต้น) */
    public const SELECTABLE = [
        'team' => 8,
        'cases' => 3,
        'news' => 3,
        'announcement' => 3,
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

    /** query เริ่มต้น + การเรียงของแต่ละ section ที่เลือกได้ */
    private static function source(string $key): ?array
    {
        return match ($key) {
            'news' => [fn () => News::published()->with('category'), 'published_at', 'desc'],
            'announcement' => [fn () => Announcement::published()->with('category'), 'published_at', 'desc'],
            'cases' => [fn () => CaseStudy::published()->with('category'), 'created_at', 'desc'],
            'team' => [fn () => TeamMember::where('is_active', true), 'order', 'asc'],
            default => null,
        };
    }

    /** รายการที่จะแสดงหน้าแรก (ตามที่เลือก หรือ ล่าสุด/ตามลำดับ) */
    public static function featured(string $key)
    {
        $src = self::source($key);
        if (! $src) {
            return collect();
        }
        [$base, $col, $dir] = $src;
        $cfg = self::config($key);

        if (($cfg['mode'] ?? 'latest') === 'selected' && ! empty($cfg['items'])) {
            $ids = $cfg['items'];

            return $base()->whereIn('id', $ids)->get()
                ->sortBy(fn ($m) => array_search($m->id, $ids))->values();
        }

        return $base()->orderBy($col, $dir)->limit(self::SELECTABLE[$key] ?? 6)->get();
    }

    /** เผื่อโค้ดเดิม */
    public static function featuredNews()
    {
        return self::featured('news');
    }
}
