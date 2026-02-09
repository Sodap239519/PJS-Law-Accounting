@extends('layouts.boomerang')

@section('title', 'บริการของเรา')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/Banner.png') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">บริการของเรา</h2>
                <p class="text-white-50">เรียนรู้เพิ่มเติมเกี่ยวกับบริการของเรา</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Services Overview -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5" data-aos="fade-up">
                <h2>บริการครบวงจรด้านกฎหมายและบัญชี</h2>
                <p class="lead">ด้วยทีมผู้เชี่ยวชาญมืออาชีพ พร้อมให้คำปรึกษาและดูแลทุกความต้องการของคุณ</p>
            </div>
        </div>
    </div>
</section>

<!-- Legal Services -->
<section class="module bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center" data-aos="fade-up">
                <i class="bi bi-briefcase" style="font-size: 64px; color: #d4af37;"></i>
                <h2 class="mt-3">ด้านกฎหมาย</h2>
                <p class="lead">บริการด้านกฎหมายครบวงจร</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-person-check" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">ที่ปรึกษาทางกฎหมาย</h4>
                        <p>ให้คำปรึกษาด้านกฎหมายธุรกิจ สัญญาต่างๆ และกฎหมายที่เกี่ยวข้อง</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-file-earmark-text" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">ร่างและตรวจสัญญา</h4>
                        <p>ร่างและตรวจสอบสัญญาทุกประเภท เพื่อปกป้องสิทธิประโยชน์ของคุณ</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-building" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">จดทะเบียนบริษัท</h4>
                        <p>จดทะเบียนจัดตั้งบริษัท ห้างหุ้นส่วน และเปลี่ยนแปลงทะเบียน</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-shield-check" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">ว่าความในศาล</h4>
                        <p>ว่าความในศาลทุกชั้น ด้วยทีมทนายความมืออาชีพ</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-search" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">สืบทรัพย์</h4>
                        <p>บริการสืบหาทรัพย์สินและตรวจสอบข้อมูลทางกฎหมาย</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-hammer" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">คดีแพ่งและอาญา</h4>
                        <p>รับว่าความคดีแพ่ง อาญา แรงงาน และคดีพิเศษ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Accounting Services -->
<section class="module">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center" data-aos="fade-up">
                <i class="bi bi-calculator" style="font-size: 64px; color: #d4af37;"></i>
                <h2 class="mt-3">ด้านบัญชี</h2>
                <p class="lead">บริการด้านบัญชีและภาษีครบวงจร</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-journal-text" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">จัดทำบัญชี</h4>
                        <p>จัดทำบัญชีรายเดือน งบการเงิน ตามมาตรฐานการบัญชี</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-file-earmark-ruled" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">ยื่นภาษี</h4>
                        <p>ยื่นภาษีมูลค่าเพิ่ม ภาษีเงินได้นิติบุคคล และภาษีอื่นๆ</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-graph-up-arrow" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">วางแผนภาษี</h4>
                        <p>วางแผนภาษีเชิงรุก เพื่อลดภาระภาษีอย่างถูกกฎหมาย</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-people" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">บัญชีเงินเดือน</h4>
                        <p>คำนวณเงินเดือน ประกันสังคม และภาษีหัก ณ ที่จ่าย</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-laptop" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">บัญชีดิจิทัล</h4>
                        <p>วางระบบบัญชีดิจิทัล ใช้งานง่าย ตรวจสอบได้ทุกที่ทุกเวลา</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-clipboard-data" style="font-size: 48px; color: #d4af37;"></i>
                        <h4 class="mt-3">ตรวจสอบบัญชี</h4>
                        <p>ตรวจสอบความถูกต้องของบัญชีและให้คำแนะนำ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="module parallax text-center" data-background="{{ asset('frontend/images/module-12.jpg') }}" data-overlay="0.7">
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h2 class="text-white mb-4" data-aos="fade-up">สนใจบริการของเราใช่ไหม?</h2>
                <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="200">ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี</p>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-lg" data-aos="zoom-in" data-aos-delay="400">ติดต่อเราเลย</a>
            </div>
        </div>
    </div>
</section>

@endsection