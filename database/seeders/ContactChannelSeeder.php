<?php

namespace Database\Seeders;

use App\Models\ContactChannel;
use Illuminate\Database\Seeder;

class ContactChannelSeeder extends Seeder
{
    public function run(): void
    {
        $channels = [
            ['type' => 'phone', 'label' => 'โทรศัพท์', 'value' => '092-256-9828', 'icon' => 'bi bi-telephone', 'sort_order' => 1],
            ['type' => 'email', 'label' => 'อีเมล', 'value' => 'pjs.legal2025@gmail.com', 'icon' => 'bi bi-envelope', 'sort_order' => 2],
            ['type' => 'address', 'label' => 'ที่อยู่', 'value' => '27/20 ซอยบางบอน4 ซอย4 แขวงบางบอนเหนือ เขตบางบอน กรุงเทพมหานคร 10150', 'icon' => 'bi bi-geo-alt', 'sort_order' => 3],
            ['type' => 'facebook', 'label' => 'Facebook', 'value' => 'https://www.facebook.com/profile.php?id=61583725895144', 'icon' => 'bi bi-facebook', 'sort_order' => 4],
            ['type' => 'instagram', 'label' => 'Instagram', 'value' => 'https://www.instagram.com/pjs_legal', 'icon' => 'bi bi-instagram', 'sort_order' => 5],
            ['type' => 'tiktok', 'label' => 'TikTok', 'value' => 'https://www.tiktok.com/@pjs_legal', 'icon' => 'bi bi-tiktok', 'sort_order' => 6],
        ];

        foreach ($channels as $channel) {
            ContactChannel::create($channel + ['is_active' => true]);
        }
    }
}
