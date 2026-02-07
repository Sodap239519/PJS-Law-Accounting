<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generalCategory = Category::where('slug', 'general-news')->first();
        $activityCategory = Category::where('slug', 'company-activities')->first();

        $newsArticles = [
            [
                'title_th' => 'บริการให้คำปรึกษาทางกฎหมายแบบครบวงจร',
                'title_en' => 'Comprehensive Legal Consultation Services',
                'slug' => 'comprehensive-legal-consultation-services',
                'excerpt_th' => 'PJS Law and Accounting ขยายบริการให้คำปรึกษาทางกฎหมายครอบคลุมทุกด้าน',
                'excerpt_en' => 'PJS Law and Accounting expands comprehensive legal consultation services covering all aspects.',
                'content_th' => 'บริษัท PJS กฎหมายและการบัญชี จำกัด ยินดีประกาศขยายบริการให้คำปรึกษาทางกฎหมายแบบครบวงจร โดยครอบคลุมตั้งแต่กฎหมายธุรกิจ กฎหมายแพ่ง กฎหมายอาญา ไปจนถึงการให้คำปรึกษาด้านภาษีและบัญชี เพื่อตอบสนองความต้องการของลูกค้าที่หลากหลายและเพิ่มความสะดวกในการใช้บริการครบจบในที่เดียว',
                'content_en' => 'PJS Law and Accounting Co., Ltd. is pleased to announce the expansion of comprehensive legal consultation services, covering business law, civil law, criminal law, to tax and accounting consultation, to meet diverse client needs and provide one-stop service convenience.',
                'category_id' => $generalCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views' => 120,
            ],
            [
                'title_th' => 'สัมมนาความรู้ทางกฎหมายสำหรับผู้ประกอบการ SME',
                'title_en' => 'Legal Knowledge Seminar for SME Entrepreneurs',
                'slug' => 'legal-knowledge-seminar-for-sme',
                'excerpt_th' => 'จัดสัมมนาให้ความรู้ทางกฎหมายสำหรับผู้ประกอบการ SME ในการป้องกันความเสี่ยงทางธุรกิจ',
                'excerpt_en' => 'Organizing a legal knowledge seminar for SME entrepreneurs on business risk prevention.',
                'content_th' => 'บริษัทฯ ได้จัดสัมมนาให้ความรู้ทางกฎหมายแก่ผู้ประกอบการ SME โดยมุ่งเน้นการป้องกันความเสี่ยงทางธุรกิจ การร่างสัญญาที่มีประสิทธิภาพ และการจัดการข้อพิพาททางธุรกิจ มีผู้ประกอบการเข้าร่วมกว่า 100 ท่าน ได้รับความรู้และคำแนะนำที่เป็นประโยชน์จากทีมทนายความผู้เชี่ยวชาญของเรา',
                'content_en' => 'The company organized a legal knowledge seminar for SME entrepreneurs, focusing on business risk prevention, effective contract drafting, and business dispute management. Over 100 entrepreneurs participated and received valuable knowledge and advice from our expert legal team.',
                'category_id' => $activityCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views' => 85,
            ],
            [
                'title_th' => 'บริการดูแลบัญชีและภาษีสำหรับธุรกิจออนไลน์',
                'title_en' => 'Accounting and Tax Services for Online Businesses',
                'slug' => 'accounting-tax-services-online-business',
                'excerpt_th' => 'เปิดตัวบริการดูแลบัญชีและภาษีเฉพาะสำหรับธุรกิจออนไลน์และ E-commerce',
                'excerpt_en' => 'Launching specialized accounting and tax services for online businesses and E-commerce.',
                'content_th' => 'ตอบสนองความต้องการของยุคดิจิทัล บริษัทฯ เปิดตัวบริการดูแลบัญชีและภาษีเฉพาะสำหรับธุรกิจออนไลน์และ E-commerce โดยมีระบบบัญชีดิจิทัลที่ทันสมัย สามารถเชื่อมต่อกับแพลตฟอร์มการขายออนไลน์ได้โดยตรง ทำให้การจัดการบัญชีและภาษีง่ายและสะดวกยิ่งขึ้น',
                'content_en' => 'Responding to digital era demands, the company launches specialized accounting and tax services for online businesses and E-commerce, featuring a modern digital accounting system that can directly integrate with online sales platforms, making accounting and tax management easier and more convenient.',
                'category_id' => $generalCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'views' => 95,
            ],
            [
                'title_th' => 'ความสำเร็จในคดีพิพาทสัญญาธุรกิจมูลค่าสูง',
                'title_en' => 'Success in High-Value Business Contract Dispute Case',
                'slug' => 'success-high-value-business-dispute',
                'excerpt_th' => 'ทีมทนายความของเราได้รับชัยชนะในคดีพิพาทสัญญาธุรกิจมูลค่าสูง',
                'excerpt_en' => 'Our legal team achieved victory in a high-value business contract dispute case.',
                'content_th' => 'ทีมทนายความของบริษัทฯ ได้รับชัยชนะในคดีพิพาทสัญญาธุรกิจมูลค่าสูง โดยศาลตัดสินให้ลูกความของเราชนะคดีและได้รับค่าเสียหายตามที่ฟ้องร้องครบถ้วน ซึ่งเป็นผลมาจากการเตรียมคดีอย่างรอบคอบและการนำเสนอพยานหลักฐานอย่างมีประสิทธิภาพ',
                'content_en' => 'Our legal team achieved victory in a high-value business contract dispute case, with the court ruling in favor of our client and awarding full damages as claimed, resulting from meticulous case preparation and effective evidence presentation.',
                'category_id' => $activityCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'views' => 150,
            ],
            [
                'title_th' => 'เปิดบริการให้คำปรึกษาออนไลน์ 24/7',
                'title_en' => 'Launching 24/7 Online Consultation Service',
                'slug' => 'launching-24-7-online-consultation',
                'excerpt_th' => 'บริการให้คำปรึกษาทางกฎหมายและบัญชีออนไลน์ตลอด 24 ชั่วโมง',
                'excerpt_en' => '24-hour online legal and accounting consultation service.',
                'content_th' => 'เพื่อความสะดวกสบายของลูกค้า บริษัทฯ เปิดบริการให้คำปรึกษาทางกฎหมายและบัญชีออนไลน์ตลอด 24 ชั่วโมง ผ่านระบบแชทออนไลน์และวิดีโอคอล สามารถติดต่อขอคำปรึกษาเบื้องต้นได้ทุกเวลา โดยทีมงานผู้เชี่ยวชาญของเราพร้อมให้บริการ',
                'content_en' => 'For client convenience, the company launches 24-hour online legal and accounting consultation services through online chat and video call systems. Preliminary consultations are available anytime with our expert team ready to serve.',
                'category_id' => $generalCategory->id,
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'views' => 200,
            ],
        ];

        foreach ($newsArticles as $article) {
            News::create($article);
        }
    }
}
