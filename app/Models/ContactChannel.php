<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactChannel extends Model
{
    protected $fillable = [
        'type',
        'label',
        'value',
        'icon',
        'sort_order',
        'is_active',
        'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    /** ประเภทที่ถือเป็นโซเชียล/แชท (ใช้ทำปุ่มลอย + ไอคอนโซเชียล) */
    public const SOCIAL_TYPES = ['line', 'facebook', 'instagram', 'tiktok', 'youtube'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** ลิงก์ปลายทางที่เหมาะกับแต่ละประเภท */
    public function getHrefAttribute(): string
    {
        return match ($this->type) {
            'phone' => 'tel:'.preg_replace('/[^0-9+]/', '', (string) $this->value),
            'email' => 'mailto:'.$this->value,
            'address' => '#',
            default => $this->value, // line/facebook/instagram/tiktok/youtube/map เป็น URL
        };
    }

    public function getIsSocialAttribute(): bool
    {
        return in_array($this->type, self::SOCIAL_TYPES, true);
    }
}
