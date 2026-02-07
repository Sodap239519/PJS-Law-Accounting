<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamMembers = [
            [
                'name_th' => 'นายธนากร ตั้งกิจโสภา',
                'name_en' => 'Thanagon Tagkidsopha',
                'position_th' => 'ประธานบริษัท',
                'position_en' => 'President',
                'bio_th' => 'ผู้นำองค์กรด้วยวิสัยทัศน์ที่กว้างไกลและประสบการณ์ในด้านกฎหมายและการบัญชีมากกว่า 15 ปี',
                'bio_en' => 'Leading the organization with a broad vision and over 15 years of experience in law and accounting.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name_th' => 'นายอธิวัฒน์ ชิดอรุณธนวัฒน์',
                'name_en' => 'Athiwat Chidarunthanawat',
                'position_th' => 'ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย',
                'position_en' => 'Legal Expert Consultant',
                'bio_th' => 'ผู้เชี่ยวชาญด้านกฎหมายธุรกิจและกฎหมายพาณิชย์ มีประสบการณ์ในการให้คำปรึกษาธุรกิจขนาดใหญ่',
                'bio_en' => 'Expert in business and commercial law with extensive experience consulting for large enterprises.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name_th' => 'นายจักรพันธ์ อยู่ยืน',
                'name_en' => 'Jukkapun Yuyuen',
                'position_th' => 'หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี',
                'position_en' => 'Head of Asset Investigation and Execution',
                'bio_th' => 'ผู้เชี่ยวชาญด้านการสืบทรัพย์และบังคับคดี มีความชำนาญในการติดตามทรัพย์สินและการบังคับคดีตามกฎหมาย',
                'bio_en' => 'Specialist in asset investigation and legal execution with expertise in asset tracking and enforcement.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name_th' => 'นางสาวพลอยไพลิน อยู่ยืน',
                'name_en' => 'Ploypailin Yuyuen',
                'position_th' => 'ทนายความ',
                'position_en' => 'Attorney at Law',
                'bio_th' => 'ทนายความที่มีความเชี่ยวชาญในคดีแพ่งและคดีอาญา พร้อมให้บริการด้วยความเอาใจใส่และรอบคอบ',
                'bio_en' => 'Attorney specializing in civil and criminal cases, providing attentive and meticulous legal services.',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }
    }
}
