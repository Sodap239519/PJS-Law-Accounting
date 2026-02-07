<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudy extends Model
{
    protected $fillable = [
        'title_th',
        'title_en',
        'slug',
        'client_name',
        'challenge_th',
        'challenge_en',
        'solution_th',
        'solution_en',
        'result_th',
        'result_en',
        'featured_image',
        'gallery',
        'category_id',
        'is_published',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'gallery' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
