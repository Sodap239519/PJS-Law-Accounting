<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'title_th',
        'title_en',
        'description_th',
        'description_en',
        'file_path',
        'file_name',
        'file_size',
        'category_id',
        'downloads',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function incrementDownloads(): void
    {
        $this->increment('downloads');
    }
}
