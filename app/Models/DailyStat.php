<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStat extends Model
{
    protected $fillable = ['date', 'views', 'messages'];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * เพิ่มตัวนับของวันนี้ (views หรือ messages)
     */
    public static function record(string $field, int $by = 1): void
    {
        if (! in_array($field, ['views', 'messages'], true)) {
            return;
        }

        $row = static::firstOrCreate(
            ['date' => today()->toDateString()],
            ['views' => 0, 'messages' => 0],
        );

        $row->increment($field, $by);
    }
}
