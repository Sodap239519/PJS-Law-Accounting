<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ข่าวทั่วไป', 'slug' => 'general-news', 'type' => 'news'],
            ['name' => 'กิจกรรมบริษัท', 'slug' => 'company-activities', 'type' => 'news'],
            ['name' => 'ประชาสัมพันธ์ทั่วไป', 'slug' => 'general-pr', 'type' => 'announcement'],
            ['name' => 'กฎหมายทั่วไป', 'slug' => 'general-law', 'type' => 'case_study'],
            ['name' => 'กฎหมายธุรกิจ', 'slug' => 'business-law', 'type' => 'case_study'],
            ['name' => 'เอกสารทั่วไป', 'slug' => 'general-documents', 'type' => 'document'],
            ['name' => 'แบบฟอร์ม', 'slug' => 'forms', 'type' => 'document'],
        ];

        foreach ($categories as $category) {
            Category::create($category + ['is_active' => true]);
        }
    }
}
