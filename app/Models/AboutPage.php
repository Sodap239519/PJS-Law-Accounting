<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutPage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'about_page';

    protected $fillable = [
        'layout',
        'intro_title',
        'intro_subtitle',
        'vision',
        'mission',
        'content',
        'sections',
    ];

    protected $casts = [
        'sections' => 'array',
    ];

    /**
     * คืนแถว singleton (สร้างถ้ายังไม่มี)
     */
    public static function singleton(): self
    {
        return static::firstOrCreate([], ['layout' => 'layout1']);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }
}
