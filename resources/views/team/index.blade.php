@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>ทีมงานของเรา</h2>
                <p>ทีมงานมืออาชีพที่พร้อมให้บริการ</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Team Members -->
<section class="module">
    <div class="container">
        <div class="row">
            <!-- Team Member 1: ประธานบริษัท -->
            <div class="col-md-4">
                <div class="team-item">
                    <div class="team-image">
                        <img src="{{ asset('frontend/images/team/1.jpg') }}" alt="นายธนากร ตั้งกิจโสภา">
                        <div class="team-wrap">
                            <div class="team-content">
                                <h6 class="team-name">นายธนากร ตั้งกิจโสภา</h6>
                                <div class="team-role">ประธานบริษัท</div>
                            </div>
                            <div class="team-content-social">
                                <ul>
                                    <li><a href="mailto:thanagon@example.com"><i class="fas fa-envelope"></i></a></li>
                                    <li><a href="tel:0812345678"><i class="fas fa-phone"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้นำองค์กรด้วยวิสัยทัศน์และประสบการณ์กว่า 15 ปี ในการบริหารจัดการและพัฒนาธุรกิจ</p>
                    </div>
                </div>
            </div>

            <!-- Team Member 2: ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย -->
            <div class="col-md-4">
                <div class="team-item">
                    <div class="team-image">
                        <img src="{{ asset('frontend/images/team/1.jpg') }}" alt="นายอธิวัฒน์ ชิดอรุณธนวัฒน์">
                        <div class="team-wrap">
                            <div class="team-content">
                                <h6 class="team-name">นายอธิวัฒน์ ชิดอรุณธนวัฒน์</h6>
                                <div class="team-role">ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย</div>
                            </div>
                            <div class="team-content-social">
                                <ul>
                                    <li><a href="mailto:athiwat@example.com"><i class="fas fa-envelope"></i></a></li>
                                    <li><a href="tel:0823456789"><i class="fas fa-phone"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้เชี่ยวชาญด้านกฎหมายธุรกิจและกฎหมายแพ่งพาณิชย์ ให้คำปรึกษาด้วยความเชี่ยวชาญและความละเอียดรอบคอบ</p>
                    </div>
                </div>
            </div>

            <!-- Team Member 3: หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี -->
            <div class="col-md-4">
                <div class="team-item">
                    <div class="team-image">
                        <img src="{{ asset('frontend/images/team/1.jpg') }}" alt="นายจักรพันธ์ อยู่ยืน">
                        <div class="team-wrap">
                            <div class="team-content">
                                <h6 class="team-name">นายจักรพันธ์ อยู่ยืน</h6>
                                <div class="team-role">หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี</div>
                            </div>
                            <div class="team-content-social">
                                <ul>
                                    <li><a href="mailto:jukkapun@example.com"><i class="fas fa-envelope"></i></a></li>
                                    <li><a href="tel:0834567890"><i class="fas fa-phone"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้เชี่ยวชาญด้านการสืบทรัพย์และบังคับคดี มีประสบการณ์ในการดำเนินคดีและติดตามทรัพย์สินอย่างมีประสิทธิภาพ</p>
                    </div>
                </div>
            </div>

            <!-- Team Member 4: ทนายความ -->
            <div class="col-md-4">
                <div class="team-item">
                    <div class="team-image">
                        <img src="{{ asset('frontend/images/team/2.jpg') }}" alt="นางสาวพลอยไพลิน อยู่ยืน">
                        <div class="team-wrap">
                            <div class="team-content">
                                <h6 class="team-name">นางสาวพลอยไพลิน อยู่ยืน</h6>
                                <div class="team-role">ทนายความ</div>
                            </div>
                            <div class="team-content-social">
                                <ul>
                                    <li><a href="mailto:ploypailin@example.com"><i class="fas fa-envelope"></i></a></li>
                                    <li><a href="tel:0845678901"><i class="fas fa-phone"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ทนายความผู้มีความเชี่ยวชาญในคดีแพ่งและอาญา พร้อมให้คำปรึกษาและดำเนินคดีด้วยความรอบคอบ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Team Members end-->

<!-- Call to Action -->
 <section class="module parallax text-center" data-background="{{ asset('frontend/images/module-12.jpg') }}" data-overlay="0.7">
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <h2 class="text-white mb-4" data-aos="fade-up">สนใจปรึกษาทีมงานของเราใช่ไหม?</h2>
                <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="200">ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี</p>
                <a href="{{ route('contact.index') }}" class="btn btn-outline-light btn-lg" data-aos="zoom-in" data-aos-delay="400">ติดต่อเราเลย</a>
            </div>
        </div>
    </div>
</section>
<!-- Call to Action end-->
@endsection
