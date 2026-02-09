@extends('layouts.boomerang')

@section('title', 'เกี่ยวกับเรา')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/Banner.png') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">เกี่ยวกับเรา</h2>
                <p class="text-white-50">เรียนรู้เพิ่มเติมเกี่ยวกับบริษัทของเรา</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Company Overview -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2>บริษัท PJS กฎหมายและการบัญชี จำกัด</h2>
                <p class="lead">ผู้เชี่ยวชาญด้านกฎหมายและบัญชีที่คุณไว้วางใจ</p>
            </div>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="icon-box text-center p-4">
                    <div class="icon-box-icon mb-3">
                        <i class="bi bi-eye" style="font-size: 48px; color: #3498db;"></i>
                    </div>
                    <h4>วิสัยทัศน์</h4>
                    <p>ความเชี่ยวชาญเหนือระดับ เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย เพื่อทุกความสำเร็จของคุณและธุรกิจ</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="icon-box text-center p-4">
                    <div class="icon-box-icon mb-3">
                        <i class="bi bi-bullseye" style="font-size: 48px; color: #e74c3c;"></i>
                    </div>
                    <h4>พันธกิจ</h4>
                    <p>ให้บริการด้านกฎหมายและบัญชีอย่างมืออาชีพ ด้วยทีมงานที่มีความรู้และประสบการณ์</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Details -->
<section class="module bg-light">
    <div class="container">
        
        <!-- ด้านกฎหมาย -->
        <div class="row align-items-center mb-5 pb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="icon-box">
                    <div class="icon-box-title mb-4">
                        <h3><i class="bi bi-briefcase" style="color: #d4af37; margin-right: 10px;"></i> ด้านกฎหมาย</h3>
                    </div>
                    <div class="icon-box-content">
                        <p>ทางบริษัท PJS กฎหมายและการบัญชี จำกัด คือ บริษัทกฎหมายที่ยึดมั่นในความถูกต้องและรักษาผลประโยชน์สูงสุดของลูกความเป็นสำคัญ ด้วยทีมทนายความผู้เชี่ยวชาญที่มีประสบการณ์สะสมมาอย่างยาวนานในการทำงาน เราไม่ได้ทำหน้าที่เพียงแค่ที่ปรึกษาด้านกฎหมาย แต่เราคือ 'พันธมิตร' ที่ช่วยวางแผนและป้องกันความเสี่ยงในทุกย่างก้าวของคุณและครอบคลุมด้านการป้องกันปัญหาทางธุรกิจ</p>
                        
                        <p>เราให้บริการครอบคลุมตั้งแต่งานที่ปรึกษาทั่วไป การร่างสัญญา สืบทรัพย์ไปจนถึงการว่าความในศาล โดยเน้นความรอบคอบ แม่นยำ และรักษาความลับของลูกความอย่างเคร่งครัด เพื่อให้คุณมั่นใจได้ว่าทุกปัญหาทางกฎหมายจะมีทางออกที่ดีที่สุดเสมอ</p>
                        
                        <p>เมื่อเผชิญกับข้อพิพาททางกฎหมาย คุณต้องการทีมที่กล้าตัดสิน���จและมีความเชี่ยวชาญทางด้านเอกสารงานคดี ทีมทนายความของเรา เชี่ยวชาญในการว่าความและแก้ปัญหาคดีความที่ซับซ้อน เราวิเคราะห์ข้อมูลเชิงลึก เข้าถึงแก่นของปัญหา และวางแผนการสู้คดีอย่างเป็นระบบ</p>
                        
                        <p><strong>เป้าหมายเดียวของเราคือผลประโยชน์ที่ยุติธรรมสำหรับลูกความ ด้วยจรรยาบรรณวิชาชีพที่มั่นคงและความทุ่มเทเกินร้อยในการทำคดี เราพร้อมยืนหยัดสู้เพื่อคุณในทุกชั้นศาล</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/images/portfolio/law.jpg') }}" alt="Legal Services" class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Divider -->
        <div class="row">
            <div class="col-md-12">
                <hr style="margin: 60px 0; border-color: rgba(0,0,0,0.1);">
            </div>
        </div>

        <!-- ด้านบัญชี -->
        <div class="row align-items-center mt-5">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="icon-box">
                    <div class="icon-box-title mb-4">
                        <h3><i class="bi bi-graph-up-arrow" style="color: #d4af37; margin-right: 10px;"></i> ด้านบัญชี</h3>
                    </div>
                    <div class="icon-box-content">
                        <p>บริษัท PJS กฎหมายและการบัญชี จำกัด มีผู้เชี่ยวชาญทางด้านบัญชีและภาษี ด้วยทีมงานที่ประกอบด้วยผู้สอบบัญชีรับอนุญาต (CPA) และที่ปรึกษาทางบัญชีมืออาชีพ เรามุ่งมั่นที่จะส่งมอบรายงานทางการเงินที่ถูกต้องแม่นยำตามมาตรฐานการบัญชี เพื่อให้ผู้บริหารสามารถนำข้อมูลไปใช้ตัดสินใจได้อย่างมั่นใจ</p>
                        
                        <p>บริษัทของเราไม่ได้เพียงแค่จัดทำตัวเลข แต่เราตรวจสอบและวิเคราะห์เพื่อปิดรอยรั่วทางการเงิน และช่วยให้ธุรกิจของคุณเติบโตบนโครงสร้างที่ถูกต้องตามกฎหมาย 100%</p>
                        
                        <p><strong>คติของเราในการทำงาน คือ บัญชีที่ดีต้องช่วยให้เจ้าของธุรกิจ "เหนื่อยน้อยลงและได้ผลลัพธ์มากขึ้น"</strong></p>
                        
                        <p>เราให้บริการดูแลบัญชีแบบครบวงจร ตั้งแต่การวางระบบบัญชีดิจิทัล การจัดทำภาษีรายเดือน ไปจนถึงการวางแผนภาษีเชิงรุก (Tax Planning) เพื่อช่วยลดค่าใช้จ่ายอย่างถูกกฎหมาย</p>
                        
                        <p>เราสามารถเปลี่ยนตัวเลขที่ซับซ้อนให้กลายเป็นข้อมูลที่เข้าใจง่าย พร้อมให้คำปรึกษาเชิงกลยุทธ์เพื่อให้คุณโฟกัสกับการขยายธุรกิจได้อย่างเต็มที่ โดยไม่ต้องกังวลเรื่องงานหลังบ้าน</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <img src="{{ asset('frontend/images/main/accounting.jpg') }}" alt="Accounting Services" class="img-fluid rounded shadow">
            </div>
        </div>
        
    </div>
</section>

<!-- Call to Action -->
<section class="module parallax text-center" data-background="{{ asset('frontend/images/module-12.jpg') }}" data-overlay="0.7">
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h2 class="text-white mb-4">พร้อมที่จะเริ่มต้นหรือยัง?</h2>
                <p class="lead text-white mb-4">ให้เราเป็นพันธมิตรทางกฎหมายและบัญชีของคุณ</p>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-lg">ติดต่อเราเลย</a>
            </div>
        </div>
    </div>
</section>
@endsection