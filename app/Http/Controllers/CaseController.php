<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaseController extends Controller
{
    private $cases = [
        1 => [
            'id' => 1,
            'icon' => 'bi bi-award-fill',
            'title_th' => 'คดีพิพาทสัญญาซื้อขายที่ดิน',
            'title_en' => 'Land Purchase Contract Dispute',
            'type' => 'คดีแพ่ง / Civil Case',
            'value' => '50 ล้านบาท / 50M Baht',
            'result_th' => 'ชนะคดี',
            'result_en' => 'Won',
            'description_th' => 'คดีพิพาทสัญญาซื้อขายที่ดินมูลค่า 50 ล้านบาท ระหว่างนักธุรกิจและบริษัทพัฒนาอสังหาริมทรัพย์ เกี่ยวกับข้อพิพาทในเงื่อนไขการชำระเงินและการโอนกรรมสิทธิ์',
            'description_en' => 'A land purchase contract dispute case worth 50 million baht between a businessman and a real estate development company regarding payment terms and ownership transfer conditions.',
            'challenge_th' => 'ลูกความถูกบริษัทพัฒนาอสังหาริมทรัพย์ฟ้องเรียกค่าเสียหายจากการผิดสัญญา โดยอ้างว่าลูกความผิดนัดชำระเงินงวดสุดท้าย แต่ความจริงคือบริษัทไม่สามารถโอนกรรมสิทธิ์ที่ดินได้ตามกำหนด',
            'challenge_en' => 'Client was sued by real estate company for breach of contract damages, claiming client defaulted on final payment, when in reality the company failed to transfer land ownership on time.',
            'solution_th' => 'ทีมทนายความของเราได้วิเคราะห์เอกสารสัญญาอย่างละเอียด พบว่าบริษัทผิดสัญญาก่อนโดยไม่สามารถโอนกรรมสิทธิ์ได้ตามกำหนด เราจึงยื่นคำให้การปฏิเสธและฟ้องแย้งเรียกค่าเสียหาย พร้อมนำเสนอหลักฐานเอกสารและพยานบุคคลที่แสดงถึงความผิดสัญญาของบริษัท',
            'solution_en' => 'Our legal team thoroughly analyzed the contract documents and found that the company breached first by failing to transfer ownership on time. We filed a defense and counterclaim with documentary evidence and witnesses proving the company\'s breach.',
            'outcome_th' => 'ศาลพิพากษาให้ลูกความชนะคดี ยกฟ้องคดีหลักของบริษัท และให้บริษัทชำระค่าเสียหายให้ลูกความ 3 ล้านบาท พร้อมทั้งสั่งให้โอนกรรมสิทธิ์ที่ดินให้ลูกความตามสัญญาเดิม',
            'outcome_en' => 'Court ruled in favor of client, dismissed company\'s lawsuit, awarded client 3 million baht in damages, and ordered company to transfer land ownership as per original contract.',
            'testimonial_th' => 'ขอบคุณทีมทนายความ PJS มากครับ ที่ช่วยผมได้รับความเป็นธรรม จากที่เกือบจะเสียทั้งเงินและที่ดิน ตอนนี้ได้ทั้งที่ดินและค่าเสียหาย ประทับใจในความเชี่ยวชาญและความตั้งใจมากครับ',
            'testimonial_en' => 'Thank you PJS legal team for helping me get justice. I almost lost both money and land, but now I have both the land and compensation. Very impressed with the expertise and dedication.'
        ],
        2 => [
            'id' => 2,
            'icon' => 'bi bi-shield-check',
            'title_th' => 'คดีฟ้องล้มละลาย',
            'title_en' => 'Bankruptcy Case',
            'type' => 'คดีล้มละลาย / Bankruptcy',
            'value' => '80 ล้านบาท / 80M Baht',
            'result_th' => 'ยกฟ้อง',
            'result_en' => 'Case Dismissed',
            'description_th' => 'คดีฟ้องล้มละลายบริษัทผู้ประกอบการ SME ที่ถูกเจ้าหนี้ฟ้องล้มละลายเนื่องจากไม่สามารถชำระหนี้ได้ตามกำหนด',
            'description_en' => 'Bankruptcy case of SME company sued by creditors for inability to repay debts on time.',
            'challenge_th' => 'บริษัทลูกความมีหนี้สินรวม 80 ล้านบาท และถูกเจ้าหนี้รายใหญ่ฟ้องล้มละลาย ซึ่งหากแพ้คดีจะต้องเลิกกิจการและเจ้าของต้องรับผิดชอบทรัพย์สินส่วนตัว',
            'challenge_en' => 'Client company had total debts of 80 million baht and was sued for bankruptcy by major creditor. If lost, would have to cease operations and owner\'s personal assets would be liable.',
            'solution_th' => 'ทีมของเราได้วิเคราะห์ฐานะการเงินของบริษัทอย่างละเอียด พบว่าบริษัทยังมีสภาพคล่อง มีสินทรัพย์และรายได้เพียงพอที่จะชำระหนี้ได้ เราจึงนำเสนอแผนการปรับโครงสร้างหนี้และหลักฐานการเงินที่แสดงถึงความสามารถในการชำระหนี้',
            'solution_en' => 'Our team analyzed the company\'s financial status in detail and found it still had liquidity, sufficient assets and income to repay debts. We presented a debt restructuring plan and financial evidence showing repayment ability.',
            'outcome_th' => 'ศาลยกฟ้องคดีล้มละลาย เนื่องจากบริษัทมีความสามารถในการชำระหนี้ และได้ตกลงแผนการชำระหนี้กับเจ้าหนี้ทุกรายเรียบร้อย บริษัทสามารถดำเนินธุรกิจต่อได้ปกติ',
            'outcome_en' => 'Court dismissed bankruptcy case as company demonstrated repayment ability and reached debt payment agreements with all creditors. Company able to continue normal operations.',
            'testimonial_th' => 'ขอบคุณทีม PJS ที่ช่วยกอบกู้บริษัทของเราไว้ได้ จากที่คิดว่าต้องปิดกิจการแล้ว ตอนนี้ยังทำธุรกิจต่อได้และมีแผนชำระหนี้ที่ชัดเจน',
            'testimonial_en' => 'Thank you PJS team for saving our company. We thought we had to close down, but now we can continue business with a clear debt repayment plan.'
        ],
        3 => [
            'id' => 3,
            'icon' => 'bi bi-briefcase-fill',
            'title_th' => 'คดีแรงงาน - เลิกจ้างไม่เป็นธรรม',
            'title_en' => 'Labor Case - Unfair Dismissal',
            'type' => 'คดีแรงงาน / Labor Law',
            'value' => '2 ล้านบาท / 2M Baht',
            'result_th' => 'ได้รับค่าชดเชย',
            'result_en' => 'Compensation Awarded',
            'description_th' => 'คดีแรงงานพนักงานระดับผู้จัดการที่ถูกเลิกจ้างโดยไม่เป็นธรรม หลังทำงานมา 15 ปี',
            'description_en' => 'Labor case of manager-level employee unfairly dismissed after 15 years of service.',
            'challenge_th' => 'ลูกความถูกบริษัทเลิกจ้างอย่างกระทันหันโดยอ้างว่าทำงานไม่มีประสิทธิภาพ แต่ความจริงคือบริษัทต้องการลดค่าใช้จ่าย โดยไม่จ่ายค่าชดเชยตามที่ควร',
            'challenge_en' => 'Client was suddenly dismissed by company claiming poor performance, when in reality company wanted to reduce costs without paying proper compensation.',
            'solution_th' => 'เรารวบรวมหลักฐานการทำงานที่ดีของลูกความ ประวัติการได้รับรางวัล และพยานเพื่อนร่วมงาน พร้อมยื่นฟ้องเรียกค่าชดเชยและค่าเสียหายตามกฎหมายแรงงาน',
            'solution_en' => 'We gathered evidence of client\'s good work performance, awards history, and colleague witnesses, then filed lawsuit claiming compensation and damages under labor law.',
            'outcome_th' => 'ศาลพิพากษาให้ลูกความชนะคดี ได้รับค่าชดเชย ค่าบอกกล่าว และค่าเสียหายรวมกว่า 2 ล้านบาท',
            'outcome_en' => 'Court ruled in favor of client, awarded severance pay, notice pay, and damages totaling over 2 million baht.',
            'testimonial_th' => 'ขอบคุณทีม PJS ที่ช่วยเรียกความเป็นธรรมให้ผม จากที่เกือบจะไม่ได้อะไรเลย ตอนนี้ได้รับสิทธิ์ครบถ้วน',
            'testimonial_en' => 'Thank you PJS team for getting me justice. From almost getting nothing, I now received my full rights.'
        ],
        4 => [
            'id' => 4,
            'icon' => 'bi bi-bank',
            'title_th' => 'คดีสืบทรัพย์และบังคับคดี',
            'title_en' => 'Asset Investigation and Enforcement',
            'type' => 'บังคับคดี / Enforcement',
            'value' => '30 ล้านบาท / 30M Baht',
            'result_th' => 'สืบทรัพย์สำเร็จ',
            'result_en' => 'Assets Recovered',
            'description_th' => 'คดีสืบทรัพย์และบังคับคดีตามคำพิพากษา เรียกเงินคืนจากลูกหนี้ที่หลบหนี',
            'description_en' => 'Asset investigation and enforcement case to recover money from debtor who fled.',
            'challenge_th' => 'ลูกหนี้หลบหนีหลังแพ้คดี โอนทรัพย์สินให้บุคคลอื่นและอ้างว่าไม่มีทรัพย์สิน ทำให้ลูกความเกือบจะไม่ได้เงินคืน',
            'challenge_en' => 'Debtor fled after losing case, transferred assets to others and claimed no assets, client almost lost all money.',
            'solution_th' => 'ทีมของเราใช้ความเชี่ยวชาญในการสืบทรัพย์ ติดตามการโอนย้ายทรัพย์สิน ยื่นคำร้องเพิกถอนการโอนทรัพย์สินที่ทุจริต และบังคับคดียึดทรัพย์สิน',
            'solution_en' => 'Our team used investigation expertise to track asset transfers, filed petition to revoke fraudulent transfers, and enforced asset seizure.',
            'outcome_th' => 'สืบทรัพย์สินได้สำเร็จ ยึดอสังหาริมทรัพย์และบังคับคดีจนได้เงินคืนให้ลูกความกว่า 30 ล้านบาท',
            'outcome_en' => 'Successfully traced assets, seized real estate and enforced judgment recovering over 30 million baht for client.',
            'testimonial_th' => 'ทีม PJS เก่งมากในการสืบทรัพย์ จากที่คิดว่าไม่มีทางได้เงินคืน ตอนนี้ได้เงินคืนเกือบเต็มจำนวน',
            'testimonial_en' => 'PJS team is excellent at asset investigation. From thinking I would never get money back, I now recovered almost the full amount.'
        ],
        5 => [
            'id' => 5,
            'icon' => 'bi bi-file-text',
            'title_th' => 'คดีละเมิดทรัพย์สินทางปัญญา',
            'title_en' => 'Intellectual Property Infringement',
            'type' => 'ทรัพย์สินทางปัญญา / IP Law',
            'value' => '10 ล้านบาท / 10M Baht',
            'result_th' => 'ชนะคดี',
            'result_en' => 'Won',
            'description_th' => 'คดีละเมิดลิขสิทธิ์ซอฟต์แวร์ของบริษัทเทคโนโลยี',
            'description_en' => 'Software copyright infringement case of technology company.',
            'challenge_th' => 'คู่กรณีลอกซอฟต์แวร์ของลูกความไปใช้และจำหน่าย โดยไม่ได้รับอนุญาต ก่อให้เกิดความเสียหายทางธุรกิจ',
            'challenge_en' => 'Opponent copied client\'s software for use and distribution without permission, causing business damages.',
            'solution_th' => 'เรายื่นฟ้องคดีละเมิดลิขสิทธิ์ พร้อมหลักฐานการพัฒนาซอฟต์แวร์ การจดลิขสิทธิ์ และความเสียหายทางธุรกิจ พร้อมขอคำสั่งศาลห้ามการละเมิด',
            'solution_en' => 'We filed copyright infringement lawsuit with evidence of software development, copyright registration, business damages, and requested court injunction.',
            'outcome_th' => 'ชนะคดี ได้รับค่าเสียหาย 10 ล้านบาท และศาลสั่งห้ามการละเมิดอย่างถาวร',
            'outcome_en' => 'Won case, awarded 10 million baht in damages, and court issued permanent injunction.',
            'testimonial_th' => 'ขอบคุณทีม PJS ที่ปกป้องผลงานของเรา ตอนนี้คู่แข่งไม่สามารถลอกเลียนแบบได้อีก',
            'testimonial_en' => 'Thank you PJS team for protecting our work. Now competitors cannot copy anymore.'
        ]
    ];

    public function show($id)
    {
        if (!isset($this->cases[$id])) {
            abort(404);
        }

        $case = $this->cases[$id];
        return view('case-single', compact('case'));
    }
}