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

<!-- Team / บุคลากร -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto text-center">
                <h1>ทีมงานของเรา</h1>
                <p class="lead">ทีมผู้เชี่ยวชาญที่พร้อมให้บริการคุณ</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="space" data-MY="60px"></div>
            </div>
        </div>

        <!-- Swiper wrapper -->
        <div class="swiper team-swiper">
            <div class="swiper-wrapper">

                <!-- Card 1 -->
                <div class="swiper-slide">
                    <div class="team-item">
                        <div class="team-image">
                            <img src="{{ asset('frontend/images/team-pjs/ธนากร1.jpg') }}" alt="นายธนากร ตั้งกิจโสภา">
                            <div class="team-wrap">
                                <div class="team-content">
                                    <h6 class="team-name">นายธนากร ตั้งกิจโสภา</h6>
                                    <div class="team-role">ประธานบริษัท</div>
                                    <div class="team-role-en">Thanagon Tagkidsopha</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-box">
                        <h6 class="number-box-header">นายธนากร ตั้งกิจโสภา</h6>
                        <div class="number-box-content">
                            <p>ประธานบริษัท</p>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้นำองค์กรด้วยวิสัยทัศน์และประสบการณ์กว่า 15 ปี ในการบริหารจัดการและพัฒนาธุรกิจ</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide">
                    <div class="team-item">
                        <div class="team-image">
                            <img src="{{ asset('frontend/images/team-pjs/อธิวัฒน์2.jpg') }}" alt="นายอธิวัฒน์ ชิดอรุณธนวัฒน์">
                            <div class="team-wrap">
                                <div class="team-content">
                                    <h6 class="team-name">นายอธิวัฒน์ ชิดอรุณธนวัฒน์</h6>
                                    <div class="team-role">ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย</div>
                                    <div class="team-role-en">Athiwat Chidarunthanawat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-box">
                        <h6 class="number-box-header">นายอธิวัฒน์ ชิดอรุณธนวัฒน์</h6>
                        <div class="number-box-content">
                            <p>ที่ปรึกษาผู้เชี่ยวชาญทางด้านกฎหมาย</p>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้เชี่ยวชาญด้านกฎหมายธุรกิจและกฎหมายแพ่งพาณิชย์ ให้คำปรึกษาด้วยความเชี่ยวชาญและความละเอียดรอบคอบ</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="swiper-slide">
                    <div class="team-item">
                        <div class="team-image">
                            <img src="{{ asset('frontend/images/team-pjs/จักรพันธ์3.jpg') }}" alt="นายจักรพันธ์ อยู่ยืน">
                            <div class="team-wrap">
                                <div class="team-content">
                                    <h6 class="team-name">นายจักรพันธ์ อยู่ยืน</h6>
                                    <div class="team-role">หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี</div>
                                    <div class="team-role-en">Jukkapun Yuyuen</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-box">
                        <h6 class="number-box-header">นายจักรพันธ์ อยู่ยืน</h6>
                        <div class="number-box-content">
                            <p>หัวหน้าฝ่ายสืบทรัพย์และบังคับคดี</p>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ผู้เชี่ยวชาญด้านการสืบทรัพย์และบังคับคดี มีประสบการณ์ในการดำเนินคดีและติดตามทรัพย์สินอย่างมีประสิทธิภาพ</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="swiper-slide">
                    <div class="team-item">
                        <div class="team-image">
                            <img src="{{ asset('frontend/images/team-pjs/พลอย4.jpg') }}" alt="นางสาวพลอยไพลิน อยู่ยืน">
                            <div class="team-wrap">
                                <div class="team-content">
                                    <h6 class="team-name">นางสาวพลอยไพลิน อยู่ยืน</h6>
                                    <div class="team-role">ทนายความ</div>
                                    <div class="team-role-en">Ploypailin Yuyuen</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-box">
                        <h6 class="number-box-header">นางสาวพลอยไพลิน อยู่ยืน</h6>
                        <div class="number-box-content">
                            <p>ทนายความ</p>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>ทนายความผู้มีความเชี่ยวชาญในคดีแพ่งและอาญา พร้อมให้คำปรึกษาและดำเนินคดีด้วยความรอบคอบ</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="swiper-slide">
                    <div class="team-item">
                        <div class="team-image">
                            <img src="{{ asset('frontend/images/team-pjs/วิชญาพร5.jpg') }}" alt="วิชญาพร ชนาธินาถ">
                            <div class="team-wrap">
                                <div class="team-content">
                                    <h6 class="team-name">คุณวิชญาพร ชนาธินาถ</h6>
                                    <div class="team-role">เลขานุการผู้บริหารและที่ปรึกษาทางด้านบัญชีภาษีอากร</div>
                                    <div class="team-role-en">Witchayaphon Chanathinat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-box">
                        <h6 class="number-box-header">คุณวิชญาพร ชนาธินาถ</h6>
                        <div class="number-box-content">
                            <p>เลขานุการผู้บริหารและที่ปรึกษาทางด้านบัญชีภาษีอากร</p>
                        </div>
                    </div>
                    <div class="team-descr">
                        <p>เชี่ยวชาญด้านบัญชีและภาษีสำหรับธุรกิจ SME บริการด้วยความใส่ใจและถูกต้อง</p>
                    </div>
                </div>

            </div>

            {{-- ปุ่มเลื่อนซ้าย/ขวา ด้านล่าง --}}
            <div class="d-flex justify-content-center mt-4">
                <button type="button" class="btn btn-outline-secondary btn-sm mx-1 team-prev" aria-label="Previous">‹</button>
                <button type="button" class="btn btn-outline-secondary btn-sm mx-1 team-next" aria-label="Next">›</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="space" data-MY="30px"></div>
            </div>
        </div>
		
    </div>
</section>
<!-- Team end -->

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
<!-- Swiper CSS (ใส่ใน <head> ได้ หรือจะใส่ตรงนี้ก็ได้) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Swiper JS (ก่อนปิด </body>) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.team-swiper', {
      slidesPerView: 4,
      slidesPerGroup: 1, // เลื่อนทีละ 1 การ์ด
      spaceBetween: 24,
      navigation: {
        nextEl: '.team-next',
        prevEl: '.team-prev'
      },
      breakpoints: {
        0:   { slidesPerView: 1, slidesPerGroup: 1 },
        576: { slidesPerView: 2, slidesPerGroup: 1 },
        992: { slidesPerView: 4, slidesPerGroup: 1 }
      }
    });
  });
</script>
@endsection