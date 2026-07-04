<?php

namespace App\Models\Concerns;

use App\Models\Link;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLinks
{
    public function links(): MorphMany
    {
        return $this->morphMany(Link::class, 'linkable')->orderBy('sort_order');
    }
}
