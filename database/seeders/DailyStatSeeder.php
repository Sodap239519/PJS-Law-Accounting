<?php

namespace Database\Seeders;

use App\Models\DailyStat;
use Illuminate\Database\Seeder;

class DailyStatSeeder extends Seeder
{
    /**
     * ข้อมูลตัวอย่าง 14 วันย้อนหลัง (ระบบจะบันทึกค่าจริงทับต่อไปตามการใช้งานจริง)
     */
    public function run(): void
    {
        for ($i = 13; $i >= 0; $i--) {
            DailyStat::updateOrCreate(
                ['date' => today()->subDays($i)->toDateString()],
                [
                    'views' => rand(40, 260),
                    'messages' => rand(0, 7),
                ],
            );
        }
    }
}
