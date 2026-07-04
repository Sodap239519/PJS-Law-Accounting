<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'PJS Law and Accounting', 'group' => 'site'],
            ['key' => 'site_tagline', 'value' => 'บริษัท พีเจเอส กฎหมายและการบัญชี จำกัด', 'group' => 'site'],
            ['key' => 'logo', 'value' => null, 'group' => 'site'],
            ['key' => 'favicon', 'value' => null, 'group' => 'site'],
            ['key' => 'contact_phone', 'value' => '092-256-9828', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'pjs.legal2025@gmail.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '27/20 ซอยบางบอน4 ซอย4 แขวงบางบอนเหนือ เขตบางบอน กรุงเทพมหานคร 10150', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
