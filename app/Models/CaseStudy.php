<?php

namespace App\Models;

use App\Models\Concerns\HasLinks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CaseStudy extends Model implements HasMedia
{
    use InteractsWithMedia, HasLinks;

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'content',
        'category_id',
        'is_published',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();   // 16:9 (optional)
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('attachments');
    }
}
