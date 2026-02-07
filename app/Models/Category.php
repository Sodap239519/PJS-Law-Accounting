<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_th',
        'name_en',
        'slug',
        'type',
        'description_th',
        'description_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class);
    }
}
