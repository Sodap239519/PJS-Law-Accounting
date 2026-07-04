@extends('layouts.boomerang')

@section('content')
<!-- Hero Section -->
<section class="module-cover parallax text-center"
         data-background="{{ asset('frontend/images/Banner.png') }}"
         data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>คดีตัวอย่าง</h2>
				<p>คดีที่น่าสนใจและเป็นประโยชน์ต่อสังคม</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->
<section class="module" id="latest-news" data-aos="fade-up">
    <div class="container">
        <div class="row row-post-masonry">
            <!-- Card 1: ข่าวจริง -->
            <div class="col-6 col-md-6 col-lg-3 post-item mb-4">
                <article class="post">
                    <div class="post-preview">
                        <img src="{{ asset('frontend/images/blog/Cases/cases-1.jpg') }}" alt="News Main" style="width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:8px;">
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header">
                            <h2 class="post-title">ฎีกาใหม่สะเทือนวงการการเงิน ศาลชี้ 'ผู้ถือบัตรเครดิต' ไม่ต้องรับผิด หากถูกมิจฉาชีพรูดบัตร ธนาคารต้องพิสูจน์ตัวผู้ใช้!</h2>
                            <div class="post-meta">17 ธันวาคม 2568</div>
                        </div>
                        <div class="post-content">
                            <p>17 ธันวาคม 2568 มีการเผยแพร่คำพิพากษาศาลฎีกาที่ได้รับความสนใจอย่างกว้างขวางในหมู่ #ผู้บริโภค และ #สถาบันการเงิน... </p>
                        </div>
                        <div class="post-more"><a class="btn btn-sm btn-outline-brand" href="/case/case-studies-show-1">อ่านเพิ่มเติม</a></div>
                    </div>
                </article>
            </div>
            <!-- Card 2: Placeholder -->
            <div class="col-6 col-md-6 col-lg-3 post-item mb-4">
                <article class="post">
                    <div class="post-preview">
                        <img src="{{ asset('frontend/images/blog/Cases/cases-2.jpg') }}" alt="News Main" style="width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:8px;">
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header">
                            <h2 class="post-title">ลูกจ้างฝ่ายการเงิน ลักเงินนายจ้าง โดยลงข้อมูล ในคอมพิวเตอร์อันเป็นเท็จ โดยพิมพ์กรอกข้อมูลจำนวนเงิน ให้น้อยกว่า จำนวนเงินที่ได้รับ</h2>
                            <div class="post-meta">22 มีนาคม 2569</div>
                        </div>
                        <div class="post-content">
                            <p>ลูกจ้างฝ่ายการเงิน มีหน้าที่รับเงินจากลูกค้า แทนนายจ้าง  แล้วจะต้องพิมพ์กรอกข้อความลงใน computer ตามความเป็นจริง... </p>
                        </div>
                        <div class="post-more"><a class="btn btn-sm btn-outline-brand" href="/case/case-studies-show-2">อ่านเพิ่มเติม</a></div>
                    </div>
                </article>
            </div>
            <!-- Card 3: Placeholder -->
            <div class="col-6 col-md-6 col-lg-3 post-item mb-4">
                <article class="post post-placeholder">
                    <div class="post-preview" style="background: #f7f7f7; display: flex; align-items: center; justify-content: center; height: 192px; border-radius:8px;">
                        <i class="bi bi-clock-history" style="font-size: 48px; color: #ccc;"></i>
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header text-center">
                            <h2 class="post-title text-muted">กำลังอัพเดตเร็ว ๆ นี้...</h2>
                        </div>
                        <div class="post-content text-center">
                            <p class="text-muted">รอคดีตัวอย่างเพิ่มเติมในอนาคต</p>
                        </div>
                    </div>
                </article>
            </div>
            <!-- Card 4: Placeholder -->
            <div class="col-6 col-md-6 col-lg-3 post-item mb-4">
                <article class="post post-placeholder">
                    <div class="post-preview" style="background: #f7f7f7; display: flex; align-items: center; justify-content: center; height: 192px; border-radius:8px;">
                        <i class="bi bi-clock-history" style="font-size: 48px; color: #ccc;"></i>
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header text-center">
                            <h2 class="post-title text-muted">กำลังอัพเดตเร็ว ๆ นี้...</h2>
                        </div>
                        <div class="post-content text-center">
                            <p class="text-muted">รอคดีตัวอย่างเพิ่มเติมในอนาคต</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="space" data-MY="30px"></div>
                <a class="btn btn-circle btn-outline-brand" href="/news">ดูข่าวสารทั้งหมด</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .post-preview img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        border-radius: 8px;
    }
    .post-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .post {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgb(0 0 0 / 8%);
        overflow: hidden;
        margin-bottom: 16px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .post-header {
        padding: 12px 16px 0 16px;
    }
    .post-title {
        font-size: 1.28rem;
        font-weight: bold;
        margin-bottom: 3px;
        margin-top: 0;
    }
    .post-meta {
        color: #888;
        font-size: 0.95rem;
        margin-bottom: 6px;
    }
    .post-content {
        padding: 5px 16px 16px 16px;
        font-size: 1.03rem;
        color: #555;
    }
    .post-more {
        padding: 0 16px 16px 16px;
    }
    .btn-outline-brand {
        border-color: #d4af37;
        color: #d4af37;
    }
    .btn-outline-brand:hover {
        background: #d4af37;
        color: #fff;
    }
    @media (max-width: 991px) {
        .row-post-masonry > .col-lg-3 { flex: 0 0 50%; max-width: 50%; }
        .row-post-masonry > .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .row-post-masonry > .col-6 { flex: 0 0 50%; max-width: 50%; }
    }
    @media (max-width: 576px) {
        .row-post-masonry > .col-lg-3,
        .row-post-masonry > .col-md-6,
        .row-post-masonry > .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush