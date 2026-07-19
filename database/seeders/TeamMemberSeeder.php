<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'นายธนากร ตั้งกิจโสภา',
                'position' => 'ประธานบริษัท',
                'bio' => 'ผู้นำองค์กรด้วยวิสัยทัศน์ที่กว้างไกลและประสบการณ์ในการบริหารจัดการและพัฒนาธุรกิจมากกว่า 15 ปี',
                'order' => 1,
                'photo' => 'ธนากร1.jpg',
            ],
            [
                'name' => 'นายอธิวัฒน์ ชิดอรุณธนวัฒน์',
                'position' => 'ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย',
                'bio' => 'ผู้เชี่ยวชาญด้านกฎหมายธุรกิจและกฎหมายพาณิชย์ มีประสบการณ์ในการให้คำปรึกษาธุรกิจขนาดใหญ่',
                'order' => 2,
                'photo' => 'อธิวัฒน์2.jpg',
            ],
            [
                'name' => 'นายจักรพันธ์ อยู่ยืน',
                'position' => 'หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี',
                'bio' => 'ผู้เชี่ยวชาญด้านการสืบทรัพย์และบังคับคดี มีความชำนาญในการติดตามทรัพย์สินและการว่าความ',
                'order' => 3,
                'photo' => 'จักรพันธ์3.jpg',
            ],
            [
                'name' => 'นางสาวพลอยไพลิน อยู่ยืน',
                'position' => 'ทนายความ',
                'bio' => 'ทนายความที่มีความเชี่ยวชาญในคดีแพ่งและคดีอาญา พร้อมให้บริการด้วยความเอาใจใส่และรอบคอบ',
                'order' => 4,
                'photo' => 'พลอย4.jpg',
            ],
            [
                'name' => 'คุณวิชญาพร ชนาธินาถ',
                'position' => 'เลขานุการและที่ปรึกษาบัญชีภาษี',
                'bio' => 'เลขานุการบริหารและที่ปรึกษาด้านบัญชีภาษี เชี่ยวชาญงานบริการบัญชีสำหรับธุรกิจ SME',
                'order' => 5,
                'photo' => 'วิชญาพร5.jpg',
            ],
        ];

        foreach ($teamMembers as $data) {
            $photo = $data['photo'] ?? null;
            unset($data['photo']);
            $member = TeamMember::firstOrCreate(['name' => $data['name']], $data + ['is_active' => true]);

            $path = public_path('frontend/images/team-pjs/'.$photo);
            if ($photo && file_exists($path) && ! $member->getFirstMedia('photo')) {
                $member->addMedia($path)->preservingOriginal()->toMediaCollection('photo');
            }
        }
    }
}
