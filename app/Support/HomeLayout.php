<?php

namespace App\Support;

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

    /** รายการ section ตามลำดับที่บันทึกไว้ (เติม section ใหม่ต่อท้าย): [{key,label,icon,visible}] */
    public static function items(): array
    {
        $saved = json_decode(Setting::get('home_sections', ''), true);
        $saved = is_array($saved) ? $saved : [];

        $items = [];
        foreach ($saved as $s) {
            $k = $s['key'] ?? null;
            if ($k && isset(self::SECTIONS[$k]) && ! isset($items[$k])) {
                $items[$k] = [
                    'key' => $k,
                    'label' => self::SECTIONS[$k]['label'],
                    'icon' => self::SECTIONS[$k]['icon'],
                    'visible' => (bool) ($s['visible'] ?? true),
                ];
            }
        }
        // section ที่ยังไม่เคยบันทึก → ต่อท้าย (เปิดแสดงเป็นค่าเริ่มต้น)
        foreach (self::SECTIONS as $k => $meta) {
            if (! isset($items[$k])) {
                $items[$k] = ['key' => $k, 'label' => $meta['label'], 'icon' => $meta['icon'], 'visible' => true];
            }
        }

        return array_values($items);
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

    /** บันทึกลำดับ + การแสดงผล */
    public static function save(array $sections): void
    {
        $clean = [];
        foreach ($sections as $s) {
            $k = $s['key'] ?? null;
            if ($k && isset(self::SECTIONS[$k])) {
                $clean[] = ['key' => $k, 'visible' => (bool) ($s['visible'] ?? true)];
            }
        }
        Setting::set('home_sections', json_encode($clean, JSON_UNESCAPED_UNICODE), 'home');
    }
}
