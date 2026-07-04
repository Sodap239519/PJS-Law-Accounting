<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $general = Category::where('slug', 'general-news')->first();
        $activity = Category::where('slug', 'company-activities')->first();

        $articles = [
            [
                'title' => 'บริการให้คำปรึกษาทางกฎหมายแบบครบวงจร',
                'slug' => 'comprehensive-legal-consultation-services',
                'excerpt' => 'PJS Law and Accounting ขยายบริการให้คำปรึกษาทางกฎหมายครอบคลุมทุกด้าน',
                'content' => '<p>บริษัท PJS กฎหมายและการบัญชี จำกัด ยินดีประกาศขยายบริการให้คำปรึกษาทางกฎหมายแบบครบวงจร ครอบคลุมตั้งแต่กฎหมายธุรกิจ กฎหมายแพ่ง กฎหมายอาญา ไปจนถึงการให้คำปรึกษาด้านภาษีและบัญชี เพื่อตอบสนองความต้องการของลูกค้าที่หลากหลายและเพิ่มความสะดวกในการใช้บริการครบจบในที่เดียว</p>',
                'category_id' => $general->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views' => 120,
            ],
            [
                'title' => 'สัมมนาความรู้ทางกฎหมายสำหรับผู้ประกอบการ SME',
                'slug' => 'legal-knowledge-seminar-for-sme',
                'excerpt' => 'จัดสัมมนาให้ความรู้ทางกฎหมายสำหรับผู้ประกอบการ SME ในการป้องกันความเสี่ยงทางธุรกิจ',
                'content' => '<p>บริษัทฯ ได้จัดสัมมนาให้ความรู้ทางกฎหมายแก่ผู้ประกอบการ SME โดยมุ่งเน้นการป้องกันความเสี่ยงทางธุรกิจ การร่างสัญญาที่มีประสิทธิภาพ และการจัดการข้อพิพาททางธุรกิจ มีผู้ประกอบการเข้าร่วมกว่า 100 ท่าน</p>',
                'category_id' => $activity->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views' => 85,
            ],
            [
                'title' => 'บริการดูแลบัญชีและภาษีสำหรับธุรกิจออนไลน์',
                'slug' => 'accounting-tax-services-online-business',
                'excerpt' => 'เปิดตัวบริการดูแลบัญชีและภาษีเฉพาะสำหรับธุรกิจออนไลน์และ E-commerce',
                'content' => '<p>ตอบสนองความต้องการของยุคดิจิทัล บริษัทฯ เปิดตัวบริการดูแลบัญชีและภาษีเฉพาะสำหรับธุรกิจออนไลน์และ E-commerce ด้วยระบบบัญชีดิจิทัลที่ทันสมัย เชื่อมต่อกับแพลตฟอร์มการขายออนไลน์ได้โดยตรง</p>',
                'category_id' => $general->id,
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'views' => 95,
            ],
        ];

        foreach ($articles as $article) {
            News::create($article);
        }
    }
}
