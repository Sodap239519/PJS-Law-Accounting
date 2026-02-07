<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessLawCategory = Category::where('slug', 'business-law')->first();
        $generalLawCategory = Category::where('slug', 'general-law')->first();

        $caseStudies = [
            [
                'title_th' => 'คดีพิพาทสัญญาซื้อขายที่ดินมูลค่าสูง',
                'title_en' => 'High-Value Land Purchase Contract Dispute Case',
                'slug' => 'high-value-land-dispute-case',
                'client_name' => 'Confidential',
                'challenge_th' => 'ลูกความถูกฟ้องเรียกค่าเสียหายจากการผิดสัญญาซื้อขายที่ดินมูลค่า 50 ล้านบาท โดยคู่กรณีอ้างว่าลูกความไม่ได้ชำระเงินตามเงื่อนไขที่ตกลงไว้',
                'challenge_en' => 'Client was sued for damages from breach of a 50 million baht land purchase contract, with the opposing party claiming non-payment according to agreed terms.',
                'solution_th' => 'ทีมทนายความได้รวบรวมพยานหลักฐานการโอนเงินและเอกสารสัญญาทั้งหมด พบว่าลูกความได้ชำระเงินครบถ้วนตามสัญญา และนำเสนอพยานหลักฐานต่อศาลอย่างเป็นระบบ',
                'solution_en' => 'The legal team compiled all payment transfer evidence and contract documents, discovering that the client had fully paid according to the contract, and systematically presented evidence to the court.',
                'result_th' => 'ศาลตัดสินให้ลูกความชนะคดี และยกฟ้อง นอกจากนี้ศาลยังสั่งให้คู่กรณีชดใช้ค่าทนายความและค่าฤชาธรรมเนียมศาลให้แก่ลูกความอีกด้วย',
                'result_en' => 'The court ruled in favor of the client and dismissed the case. Additionally, the court ordered the opposing party to compensate the client for attorney fees and court costs.',
                'category_id' => $businessLawCategory->id,
                'is_published' => true,
                'views' => 180,
            ],
            [
                'title_th' => 'คดีละเมิดลิขสิทธิ์ซอฟต์แวร์',
                'title_en' => 'Software Copyright Infringement Case',
                'slug' => 'software-copyright-infringement-case',
                'client_name' => 'Technology Startup',
                'challenge_th' => 'บริษัทสตาร์ทอัพด้านเทคโนโลยีถูกฟ้องละเมิดลิขสิทธิ์ซอฟต์แวร์ โดยคู่กรณีอ้างว่าซอฟต์แวร์ของลูกความลอกเลียนแบบผลิตภัณฑ์ของตน',
                'challenge_en' => 'A technology startup was sued for software copyright infringement, with the opposing party claiming the client\'s software copied their product.',
                'solution_th' => 'ทีมงานได้วิเคราะห์โค้ดซอร์สโค้ดและเอกสารการพัฒนาทั้งหมด พบว่าซอฟต์แวร์ของลูกความถูกพัฒนาขึ้นเองโดยสมบูรณ์ และมีหลักฐานการพัฒนาที่ชัดเจนตั้งแต่เริ่มต้นโครงการ',
                'solution_en' => 'The team analyzed all source code and development documentation, finding that the client\'s software was completely independently developed with clear evidence of development from project inception.',
                'result_th' => 'ศาลตัดสินให้ลูกความชนะคดี และคู่กรณีต้องชดใช้ค่าเสียหายและค่าใช้จ่ายในการดำเนินคดีทั้งหมดให้แก่ลูกความ',
                'result_en' => 'The court ruled in favor of the client, and the opposing party was required to compensate all damages and litigation costs to the client.',
                'category_id' => $businessLawCategory->id,
                'is_published' => true,
                'views' => 145,
            ],
            [
                'title_th' => 'คดีสืบทรัพย์และบังคับคดีหนี้ค้างชำระ',
                'title_en' => 'Asset Investigation and Debt Collection Case',
                'slug' => 'asset-investigation-debt-collection',
                'client_name' => 'Private Company',
                'challenge_th' => 'ลูกความมีลูกหนี้ค้างชำระเงินกู้จำนวน 30 ล้านบาท โดยลูกหนี้ได้ซ่อนทรัพย์สินและหลบหนี ทำให้ไม่สามารถติดตามทวงถามหนี้ได้',
                'challenge_en' => 'Client had a debtor owing 30 million baht in outstanding loans, with the debtor hiding assets and evading contact, making debt collection impossible.',
                'solution_th' => 'ทีมสืบทรัพย์ได้ดำเนินการตรวจสอบและสืบค้นทรัพย์สินของลูกหนี้อย่างละเอียด พบทรัพย์สินหลายรายการที่ถูกโอนให้บุคคลที่สาม และยื่นคำร้องต่อศาลให้เพิกถอนการโอนทรัพย์สิน',
                'solution_en' => 'The asset investigation team thoroughly examined and traced the debtor\'s assets, discovering multiple properties transferred to third parties, and filed a petition to the court to revoke the asset transfers.',
                'result_th' => 'ศาลสั่งเพิกถอนการโอนทรัพย์สินและอนุญาตให้บังคับคดียึดทรัพย์สิน ลูกความได้รับเงินคืนครบถ้วน 100% พร้อมดอกเบี้ยและค่าเสียหาย',
                'result_en' => 'The court ordered the asset transfers revoked and authorized execution to seize the properties. The client received full 100% repayment plus interest and damages.',
                'category_id' => $generalLawCategory->id,
                'is_published' => true,
                'views' => 220,
            ],
        ];

        foreach ($caseStudies as $case) {
            CaseStudy::create($case);
        }
    }
}
