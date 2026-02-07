<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_th' => 'ข่าวทั่วไป',
                'name_en' => 'General News',
                'slug' => 'general-news',
                'type' => 'news',
                'is_active' => true,
            ],
            [
                'name_th' => 'กิจกรรมบริษัท',
                'name_en' => 'Company Activities',
                'slug' => 'company-activities',
                'type' => 'news',
                'is_active' => true,
            ],
            [
                'name_th' => 'กฎหมายทั่วไป',
                'name_en' => 'General Law',
                'slug' => 'general-law',
                'type' => 'case_study',
                'is_active' => true,
            ],
            [
                'name_th' => 'กฎหมายธุรกิจ',
                'name_en' => 'Business Law',
                'slug' => 'business-law',
                'type' => 'case_study',
                'is_active' => true,
            ],
            [
                'name_th' => 'เอกสารทั่วไป',
                'name_en' => 'General Documents',
                'slug' => 'general-documents',
                'type' => 'document',
                'is_active' => true,
            ],
            [
                'name_th' => 'แบบฟอร์ม',
                'name_en' => 'Forms',
                'slug' => 'forms',
                'type' => 'document',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
