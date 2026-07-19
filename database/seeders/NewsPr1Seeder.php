<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;

/**
 * ดึงข่าว hardcode เดิม "เปิดบริษัทและทำบุญบริษัทฯ" (โฟลเดอร์ News-PR1) เข้า DB
 * พร้อมย่อรูปด้วย GD (ต้นฉบับ 7-13MB/รูป → เว็บ ~ไม่กี่ร้อย KB)
 */
class NewsPr1Seeder extends Seeder
{
    private string $dir = '';

    public function run(): void
    {
        @ini_set('memory_limit', '1024M');
        $this->dir = public_path('frontend/images/blog/News-PR1');

        if (! is_dir($this->dir)) {
            $this->command?->warn('ข้าม NewsPr1Seeder: ไม่พบโฟลเดอร์ News-PR1');

            return;
        }

        $activity = Category::where('slug', 'company-activities')->first();

        $news = News::firstOrCreate(
            ['slug' => 'pjs-opening-merit-ceremony'],
            [
                'title' => 'เปิดบริษัทและทำบุญบริษัทฯ',
                'excerpt' => 'พิธีเปิดและทำบุญบริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด เพื่อความเป็นสิริมงคลและความเป็นอันหนึ่งอันเดียวกันของพนักงานและบริษัทฯ',
                'content' => '<p>วันที่ 6 มีนาคม 2569 ที่ผ่านมา บริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด นำโดยผู้บริหาร คุณธนากร ตั้งกิจโสภา และทีมงานของบริษัทฯ ได้ร่วมพิธีเปิดบริษัทและทำบุญบริษัทฯ ณ ที่ทำการบริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด เพื่อความเป็นสิริมงคลและความเป็นอันหนึ่งอันเดียวกันของพนักงานและบริษัทฯ</p>'
                    .'<p>บริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด เป็นผู้ให้บริการทางด้านกฎหมายและบัญชี โดยทีมงานผู้มีประสบการณ์ในทางด้านกฎหมายและด้านบัญชี ครอบคลุมถึงการให้คำปรึกษาทางกฎหมายในด้านธุรกิจและแรงงาน</p>',
                'category_id' => $activity?->id,
                'is_published' => true,
                'published_at' => '2026-03-06 09:00:00',
                'views' => 64,
            ]
        );

        // ---- รูปปก ----
        if (! $news->getFirstMedia('cover')) {
            if ($tmp = $this->resized('Photo_380_0.jpg', 1600, 80)) {
                $news->addMedia($tmp)->usingFileName('cover.jpg')->usingName('เปิดบริษัทและทำบุญบริษัทฯ')->toMediaCollection('cover');
            }
        }

        // ---- ภาพประกอบ (gallery) ----
        if ($news->getMedia('gallery')->isEmpty()) {
            $gallery = [
                'Photo_220_0.jpg', 'Photo_226_0.jpg', 'Photo_254_0.jpg', 'Photo_242_0.jpg',
                'Photo_248_0.jpg', 'Photo_250_0.jpg', 'Photo_235_0.jpg', 'Photo_227_0.jpg', 'Photo_231_0.jpg',
                'Photo_298_0.jpg', 'Photo_304_0.jpg', 'Photo_310_0.jpg', 'Photo_193_0.jpg',
                'Photo_199_0.jpg', 'Photo_205_0.jpg', 'Photo_211_0.jpg', 'Photo_212_0.jpg', 'Photo_209_0.jpg',
                'Photo_213_0.jpg', 'Photo_143_0.jpg', 'Photo_178_0.jpg', 'Photo_190_0.jpg', 'Photo_108_0.jpg',
                'Photo_119_0.jpg', 'Photo_183_0.jpg', 'Photo_215_0.jpg', 'Photo_210_0.jpg', 'Photo_203_0.jpg',
                'Photo_105(1).jpg', 'Photo_145_0.jpg', 'Photo_004_0.jpg',
            ];

            foreach ($gallery as $i => $file) {
                if ($tmp = $this->resized($file, 1280, 76)) {
                    $news->addMedia($tmp)
                        ->usingFileName('photo-'.($i + 1).'.jpg')
                        ->usingName('ภาพกิจกรรม '.($i + 1))
                        ->toMediaCollection('gallery');
                }
            }
        }

        $this->command?->info('NewsPr1Seeder: เพิ่มข่าว "เปิดบริษัทและทำบุญบริษัทฯ" + รูปย่อขนาดแล้ว');
    }

    /** ย่อรูป JPEG/PNG ด้วย GD → ไฟล์ชั่วคราว (คืน path หรือ null) */
    private function resized(string $filename, int $maxW, int $quality): ?string
    {
        $src = $this->dir.DIRECTORY_SEPARATOR.$filename;
        if (! is_file($src)) {
            return null;
        }

        $info = @getimagesize($src);
        if (! $info) {
            return null;
        }

        $img = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($src),
            IMAGETYPE_PNG => @imagecreatefrompng($src),
            default => null,
        };
        if (! $img) {
            return null;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        if ($w > $maxW) {
            $scaled = imagescale($img, $maxW, (int) round($h * $maxW / $w));
            if ($scaled) {
                imagedestroy($img);
                $img = $scaled;
            }
        }

        $tmp = tempnam(sys_get_temp_dir(), 'pjsimg').'.jpg';
        imagejpeg($img, $tmp, $quality);
        imagedestroy($img);

        return $tmp;
    }
}
