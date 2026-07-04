<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Link extends Model
{
    protected $fillable = [
        'label',
        'url',
        'sort_order',
    ];

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
