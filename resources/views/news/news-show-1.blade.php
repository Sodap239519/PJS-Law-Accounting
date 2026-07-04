@extends('layouts.boomerang')

@section('content')
<!-- Hero Section -->
<section class="module-cover parallax text-center"
         data-background="{{ asset('frontend/images/blog/News-PR1/Photo_380_0.jpg') }}"
         data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>ข่าวสารและกิจกรรม</h2>
                <p>อัพเดทข่าวสารล่าสุดของเรา</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<div class="container py-4">
    <!-- Directory/หัวข้อข่าว -->
    <div class="position-relative mb-4" style="min-height:60px;">
        <h1 class="text-center fw-bold mb-0" style="font-size:2.7rem;">เปิดบริษัทและทำบุญบริษัทฯ</h1>
    </div>
    <div class="news-meta text-center mb-3" style="font-size:1.09rem;">
        วันที่เผยแพร่: 6 มีนาคม 2569
    </div>
    <div class="news-detail mb-5">
        วันที่ 6 มีนาคม 2569 ที่ผ่านมา บริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด นำโดยผู้บริหาร คุณธนากร ตั้งกิจโสภา และ ทีมงานของบริษัทฯ ได้ร่วมพิธีเปิดบริษัทและทำบุญบริษัทฯ ณ ที่ทำการบริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด เพื่อความเป็นสิริมงคลและความเป็นอันหนึ่งอันเดียวกันของพนักงานและบริษัทฯ <br>
        บริษัท พีเจเอส.กฎหมายและการบัญชี จำกัด เป็นผู้ให้บริการทางด้านกฎหมายและบัญชี โดยมีการให้บริการ โดยทีมงานผู้มีประสบการณ์การในทางด้านกฎหมายและด้านบัญชี ครอบคลุมถึงการให้คำปรึกษาทางกฎหมายในด้านธุรกิจและแรงงาน
    </div>

    <!-- Gallery รูปภาพ (4 card ทุกขนาด) -->
    @php
        $images = [
            'Photo_220_0.jpg','Photo_226_0.jpg','Photo_254_0.jpg','Photo_242_0.jpg',
            'Photo_248_0.jpg','Photo_250_0.jpg','Photo_235_0.jpg','Photo_227_0.jpg','Photo_231_0.jpg',
            'Photo_298_0.jpg','Photo_304_0.jpg','Photo_310_0.jpg','Photo_380_0.jpg','Photo_193_0.jpg',
            'Photo_199_0.jpg','Photo_205_0.jpg','Photo_211_0.jpg','Photo_212_0.jpg','Photo_209_0.jpg',
            'Photo_213_0.jpg','Photo_143_0.jpg','Photo_178_0.jpg','Photo_190_0.jpg','Photo_108_0.jpg',
            'Photo_119_0.jpg','Photo_183_0.jpg','Photo_215_0.jpg','Photo_210_0.jpg','Photo_203_0.jpg',
            'Photo_105(1).jpg','Photo_145_0.jpg','Photo_004_0.jpg'
        ];
    @endphp
    <div class="news-gallery row gx-4 gy-4" style="--bs-gutter-x:1.1rem;--bs-gutter-y:1.1rem;">
        @foreach($images as $img)
        <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 d-flex flex-column align-items-center mb-4">
            <a href="{{ asset('frontend/images/blog/News-PR1/' . $img) }}"
               data-fancybox="news-gallery">
                <img src="{{ asset('frontend/images/blog/News-PR1/' . $img) }}"
                     alt=""
                     style="width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:.2s;">
            </a>
        </div>
        @endforeach
    </div>
    <div class="mt-5 text-center">
        <a href="/news" class="btn btn-outline-primary btn-circle">กลับหน้าข่าวสารทั้งหมด</a>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
<style>
    .news-gallery img:hover {
        box-shadow: 0 10px 36px rgba(52,80,230,0.13);
        filter: brightness(0.97);
    }
    .news-detail { font-size: 1.08rem; margin-bottom: 48px; }
    .news-meta { color: #888; }

    /* บังคับแถวละ 4 ทุกขนาดหน้าจอ */
    .news-gallery .col-6 { flex: 0 0 25%; max-width: 25%; }

    @media (max-width: 991px) {
        .news-gallery .col-6 { flex: 0 0 25%; max-width: 25%; }
        /* h1 */
        h1.text-center { font-size: 1.35rem; }
    }
    @media (max-width: 768px) {
        .news-gallery .col-6 { flex: 0 0 25%; max-width: 25%; }
    }
    @media (max-width: 576px) {
        .news-gallery .col-6 { flex: 0 0 25%; max-width: 25%; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
@endpush