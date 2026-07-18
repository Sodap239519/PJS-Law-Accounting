<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TeamMember extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'position',
        'bio',
        'socials',
        'order',
        'is_active',
        'translations',
    ];

    protected $casts = [
        'socials' => 'array',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
