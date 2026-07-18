@extends('layouts.boomerang')

@section('title', 'หน้าหลัก - PJS กฎหมายและการบัญชี')
@section('header-class', 'header-transparent')

@section('content')
    @php
        // จัดการแสดงผล/ลำดับ section หน้าแรก (แก้ได้ที่ ตั้งค่าระบบ › จัดการหน้าแรก)
        $hl = fn ($k) => 'order:'.($homeLayout[$k]['order'] ?? 99).';'.(($homeLayout[$k]['visible'] ?? true) ? '' : 'display:none;');
    @endphp
    <div class="home-sections" style="display:flex; flex-direction:column;">
    <!-- Hero Section -->
    @php($hero = ($banners ?? collect())->first())
    <section class="module-cover parallax text-center fullscreen" style="{{ $hl('hero') }}" data-background="{{ $hero && $hero->getFirstMediaUrl('image') ? $hero->getFirstMediaUrl('image') : asset('frontend/images/Banner.png') }}" data-overlay="0.6">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if($hero && $hero->title)
                        <h1 class="m-b-20"><strong>{!! nl2br(e($hero->title)) !!}</strong></h1>
                        @if($hero->subtitle)
                            <p class="m-b-40">{!! nl2br(e($hero->subtitle)) !!}</p>
                        @endif
                        <p>
                            @if($hero->link_url)
                                <a class="btn btn-lg btn-circle btn-brand" href="{{ $hero->link_url }}">ดูเพิ่มเติม</a>
                            @endif
                            <a class="btn btn-lg btn-circle btn-outline-new-white" href="{{ route('contact.index') }}">ปรึกษาคดีด่วน</a>
                        </p>
                    @else
                        <h1 class="m-b-20">
                            <strong>
                                ความเชี่ยวชาญเหนือระดับ<br>
                                เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย<br>
                                เพื่อทุกความสำเร็จของคุณและธุรกิจ
                            </strong>
                        </h1>
                        <p class="m-b-40">
                            บริษัทกฎหมายที่ยึดมั่นในความถูกต้องและรักษาผลประโยชน์สูงสุดของลูกความเป็นสำคัญ<br>
                            ด้วยทีมทนายความผู้เชี่ยวชาญที่มีประสบการณ์สะสมมาอย่างยาวนาน
                        </p>
                        <p>
                            <a class="btn btn-lg btn-circle btn-brand" href="{{ route('contact.index') }}">ปรึกษาคดีด่วน</a>
                            <a class="btn btn-lg btn-circle btn-outline-new-white" href="{{ route('about.index') }}">เรียนรู้เพิ่มเติม</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Hero end -->

    <!-- About / เกี่ยวกับเรา -->
    <section class="module divider-bottom" style="{{ $hl('about') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto text-center">
                    <h1>เกี่ยวกับเรา</h1>
                    <p class="lead">{{ $about->intro_title ?: 'บริษัท PJS กฎหมายและการบัญชี จำกัด' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="60px"></div>
                </div>
            </div>

            @if(!empty($about->sections))
                {{-- ดึงเนื้อหาจากหน้าเกี่ยวกับเรา (2 section แรก) --}}
                @foreach(array_slice($about->sections, 0, 2) as $idx => $s)
                    @if(($s['position'] ?? 'left') === 'full')
                        <div class="row align-items-center m-b-80 {{ $idx > 0 ? 'mt-5' : '' }}">
                            <div class="col-lg-10 m-auto">
                                <div class="icon-box-title"><h3>@if(!empty($s['icon']))<i class="{{ $s['icon'] }}"></i> @endif{{ $s['heading'] ?? '' }}</h3></div>
                                <div class="icon-box-content">{!! $s['content'] ?? '' !!}</div>
                            </div>
                        </div>
                    @else
                        <div class="row align-items-center m-b-80 {{ $idx > 0 ? 'mt-5' : '' }}">
                            <div class="col-lg-6 {{ ($s['position'] ?? 'left') === 'left' ? 'order-lg-2' : '' }}">
                                <div class="icon-box-title"><h3>@if(!empty($s['icon']))<i class="{{ $s['icon'] }}"></i> @endif{{ $s['heading'] ?? '' }}</h3></div>
                                <div class="icon-box-content">{!! $s['content'] ?? '' !!}</div>
                            </div>
                            <div class="col-lg-6 {{ ($s['position'] ?? 'left') === 'left' ? 'order-lg-1' : '' }}">
                                @if(!empty($s['image']))<img src="{{ $s['image'] }}" alt="{{ $s['heading'] ?? '' }}" class="img-fluid rounded">@endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
            <!-- ด้านกฎหมาย -->
            <div class="row align-items-center m-b-80">
                <div class="col-lg-6">
                        <div class="icon-box-title">
                            <h3><i class="bi bi-briefcase"></i> ด้านกฎหมาย</h3>
                        </div>
                        <div class="icon-box-content">
                            <p>ทางบริษัท PJS กฎหมายและการบัญชี จำกัด คือ บริษัทกฎหมายที่ยึดมั่นในความถูกต้องและรักษาผลประโยชน์สูงสุดของลูกความเป็นสำคัญ ด้วยทีมทนายความผู้เชี่ยวชาญที่มีประสบการณ์สะสมมาอย่างยาวนานในการทำงาน เราไม่ได้ทำหน้าที่เพียงแค่ที่ปรึกษาด้านกฎหมาย แต่เราคือ 'พันธมิตร' ที่ช่วยวางแผนและป้องกันความเสี่ยงในทุกย่างก้าวของคุณและครอบคลุมด้านการป้องกันปัญหาทางธุรกิจ</p>
                            
                            <p>เราให้บริการครอบคลุมตั้งแต่งานที่ปรึกษาทั่วไป การร่างสัญญา สืบทรัพย์ไปจนถึงการว่าความในศาล โดยเน้นความรอบคอบ แม่นยำ และรักษาความลับของลูกความอย่างเคร่งครัด เพื่อให้คุณมั่นใจได้ว่าทุกปัญหาทางกฎหมายจะมีทางออกที่ดีที่สุดเสมอ</p>
                            
                            <p>เมื่อเผชิญกับข้อพิพาททางกฎหมาย คุณต้องการทีมที่กล้าตัดสินใจและมีความเชี่ยวชาญทางด้านเอกสารงานคดี ทีมทนายความของเรา เชี่ยวชาญในการว่าความและแก้ปัญหาคดีความที่ซับซ้อน เราวิเคราะห์ข้อมูลเชิงลึก เข้าถึงแก่นของปัญหา และวางแผนการสู้คดีอย่างเป็นระบบ</p>
                            
                            <p><strong>เป้าหมายเดียวของเราคือผลประโยชน์ที่ยุติธรรมสำหรับลูกความ ด้วยจรรยาบรรณวิชาชีพที่มั่นคงและความทุ่มเทเกินร้อยในการทำคดี เราพร้อมยืนหยัดสู้เพื่อคุณในทุกชั้นศาล</strong></p>
                        </div>
                        {{-- <div class="icon-box-link"><a href="{{ route('about.legal') }}">อ่านเพิ่มเติม</a></div> --}}
                   
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('frontend/images/portfolio/law.jpg') }}" alt="Legal Services" class="img-fluid rounded">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="60px"></div>
                </div>
            </div>

            <!-- ด้านบัญชี -->
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="icon-box icon-box-left">
                        <div class="icon-box-title">
                            <h3><i class="bi bi-graph-up-arrow"></i> ด้านบัญชี</h3>
                        </div>
                        <div class="icon-box-content">
                        <p>บริษัท PJS กฎหมายและการบัญชี จำกัด มีผู้เชี่ยวชาญทางด้านบัญชีและภาษี ด้วยทีมงานที่ประกอบด้วยผู้สอบบัญชีรับอนุญาต (CPA) และที่ปรึกษาทางบัญชีมืออาชีพ เรามุ่งมั่นที่จะส่งมอบรายงานทางการเงินที่ถูกต้องแม่นยำตามมาตรฐานการบัญชี เพื่อให้ผู้บริหารสามารถนำข้อมูลไปใช้ตัดสินใจได้อย่างมั่นใจ</p>
                        
                        <p>บริษัทของเราช่วยให้ธุรกิจของคุณเติบโตบนโครงสร้างที่ถูกต้องตามกฎหมาย</p>
                        
                        <p><strong>คติของเราในการทำงาน คือ บัญชีที่ดีต้องช่วยให้เจ้าของธุรกิจ "เหนื่อยน้อยลงและได้ผลลัพธ์มากขึ้น"</strong></p>
                        
                        <p>เราให้บริการดูแลบัญชีแบบครบวงจร ตั้งแต่การวางระบบบัญชีดิจิทัล การจัดทำภาษีรายเดือน ไปจนถึงการวางแผนภาษีเชิงรุก (Tax Planning) เพื่อช่วยลดค่าใช้จ่ายอย่างถูกกฎหมาย</p>
                        
                        <p>พร้อมให้คำปรึกษาเชิงกลยุทธ์เพื่อให้คุณโฟกัสกับการขยายธุรกิจได้อย่างเต็มที่ </p>
                    </div>
                        {{-- <div class="icon-box-link"><a href="{{ route('about.accounting') }}">อ่านเพิ่มเติม</a></div> --}}
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <img src="{{ asset('frontend/images/main/accounting.jpg') }}" alt="Accounting Services" class="img-fluid">
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- About end -->

    <!-- Vision / วิสัยทัศน์ -->
    <section class="module parallax text-center" style="{{ $hl('vision') }}" data-background="{{ asset('frontend/images/module-12.jpg') }}" data-overlay="0.6">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="m-b-30">
                        <i class="bi bi-eye" style="font-size: 64px; color: #fff;"></i>
                    </div>
                    <h2  style="color: #FFD700;">วิสัยทัศน์</h2>
                    <p class="lead text-white" style="font-size: 2rem; font-weight: 500;">
                        ความเชี่ยวชาญเหนือระดับ เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย<br>
                        เพื่อทุกความสำเร็จของคุณและธุรกิจ
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Vision end -->

    <!-- Team / บุคลากร -->
<section class="module" style="{{ $hl('team') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto text-center">
                <h1>บุคลากรของเรา</h1>
                <p class="lead">ทีมผู้เชี่ยวชาญที่พร้อมให้บริการคุณ</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="space" data-MY="60px"></div>
            </div>
        </div>

        {{-- Swiper wrapper --}}
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
                </div>

                <!-- Card 5 (เพิ่มใหม่) -->
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

        <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                    <a class="btn btn-circle btn-outline-brand" href="{{ route('team.index') }}">ดูทีมงานทั้งหมด</a>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Team end -->

    <!-- Case Study / คดีตัวอย่าง -->
    <section class="module bg-gray divider-top" id="case-studies" style="{{ $hl('cases') }}" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto text-center">
                    <h1>คดีตัวอย่าง</h1>
                    <p class="lead">คดีที่น่าสนใจและเป็นประโยชน์ต่อสังคม</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="60px"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="post">
                        <div class="post-wrapper">
                            <div class="post-header">
                                <h3 class="post-title">ฎีกาใหม่สะเทือนวงการการเงิน ศาลชี้ 'ผู้ถือบัตรเครดิต' ไม่ต้องรับผิด หากถูกมิจฉาชีพรูดบัตร ธนาคารต้องพิสูจน์ตัวผู้ใช้!</h3>
                                <div class="post-meta">17 ธันวาคม 2568</div>
                            </div>
                            <div class="post-content">
                                <p><strong>คำพิพากษาฎีกาที่ 2624/2568</strong></p>
                                
                                <p>17 ธันวาคม 2568 มีการเผยแพร่คำพิพากษาศาลฎีกาที่ได้รับความสนใจอย่างกว้างขวางในหมู่ #ผู้บริโภค และ #สถาบันการเงิน คือ คำพิพากษาฎีกาที่ 2624/2568 ซึ่งวางบรรทัดฐานสำคัญเกี่ยวกับความรับผิดกรณีข้อมูลบัตรเครดิตถูกนำไปใช้โดยมิชอบ</p>

                                <p>คดีดังกล่าวเป็นกรณีที่ผู้บริโภคถูก #คนร้ายนำข้อมูลบัตรเครดิตไป #รูดซื้อสินค้าโดยไม่ได้รับอนุญาต ธนาคารผู้ออกบัตรเรียกให้เจ้าของบัตรชำระหนี้ โดยอ้างว่าเป็นภาระหน้าที่ของผู้ถือบัตรตามสัญญา แต่ผู้บริโภคปฏิเสธ โดยยืนยันว่าไม่ใช่ผู้ใช้บัตรและไม่เคยยินยอมให้ทำธุรกรรมดังกล่าว</p>

                                <h5>ศาลฎีกาชี้ชัด ภาระพิสูจน์อยู่ที่ธนาคาร</h5>
                                <p>ศาลฎีกาวินิจฉัยว่า ในกรณีที่มีข้อพิพาทว่า ใครเป็นผู้ใช้บัตรเครดิต #ภาระการพิสูจน์ตกเป็นของธนาคารผู้ออกบัตร ไม่ใช่ผู้บริโภค เนื่องจากธนาคารเป็นฝ่ายจัดทำระบบบัตรเครดิต ระบบยืนยันตัวตน และเป็นผู้ได้รับประโยชน์จากการให้บริการดังกล่าว</p>

                                <p>ศาลเห็นว่า การที่มีรายการใช้บัตรเกิดขึ้น ไม่อาจสันนิษฐานได้โดยอัตโนมัติว่า เจ้าของบัตรเป็นผู้ใช้ หากธนาคารไม่สามารถนำพยานหลักฐานมายืนยันได้ชัดเจนว่า ผู้ถือบัตรเป็นผู้ทำธุรกรรมเอง หรือมีส่วนร่วมโดยประมาทเลินเล่ออย่างร้ายแรง ศาลย่อมไม่อาจให้ผู้บริโภครับผิดชำระหนี้แทนคนร้ายได้</p>

                                <h5>ยกฟ้องผู้บริโภค ไม่ต้องชำระยอดค้าง</h5>
                                <p>ผลคำพิพากษา ศาลฎีกามีคำสั่ง <strong>ยกฟ้อง</strong> ผู้ถือบัตรเครดิต โดยระบุว่า ผู้บริโภคไม่ต้องรับผิดในยอดใช้จ่ายที่เกิดจากการกระทำของมิจฉาชีพ เนื่องจากธนาคารไม่สามารถพิสูจน์ได้ว่า ผู้ถือบัตรเป็นผู้ใช้บัตรจริง</p>

                                <h5>นักกฎหมายชี้ เป็นหมุดหมายใหม่คุ้มครองผู้บริโภค</h5>
                                <p>นักกฎหมายด้านคุ้มครองผู้บริโภคประเมินว่า คำพิพากษาฎีกานี้ถือเป็น <strong>แนวคำวินิจฉัยสำคัญ</strong> ที่ช่วยยกระดับสิทธิของผู้ใช้บัตรเครดิต และกดดันให้สถาบันการเงินต้องพัฒนาระบบความปลอดภัย การยืนยันตัวตน และกระบวนการตรวจสอบการทุจริตให้รัดกุมมากขึ้น</p>
                            </div>
                            {{-- <div class="post-more text-center m-t-30">
                                <a class="btn btn-circle btn-outline-brand" href="{{ route('cases.index') }}">ดูคดีตัวอย่างทั้งหมด</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Case Study end -->

    <!-- Latest News / ข่าวสารและกิจกรรม -->
<section class="module" id="latest-news" style="{{ $hl('news') }}" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto text-center">
                <h1>ข่าวสารและกิจกรรม</h1>
                <p class="lead">อัพเดทข่าวสารและกิจกรรมล่าสุดของเรา</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="space" data-MY="40px"></div>
            </div>
        </div>
        <div class="row row-post-masonry">
            @forelse(($latestNews ?? []) as $news)
            <div class="col-4 post-item">
                <article class="post">
                    <div class="post-preview">
                        <a href="{{ route('news.show', $news->slug) }}">
                            <img src="{{ $news->getFirstMediaUrl('cover') ?: asset('frontend/images/blog/News-PR1/Photo_380_0.jpg') }}" alt="{{ $news->title }}">
                        </a>
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header">
                            <h2 class="post-title"><a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a></h2>
                            <div class="post-meta">{{ optional($news->published_at)->locale('th')->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="post-content">
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?: $news->content), 120) }}</p>
                        </div>
                        <div class="post-more"><a href="{{ route('news.show', $news->slug) }}">อ่านเพิ่มเติม</a></div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-4 post-item">
                <article class="post post-placeholder">
                    <div class="post-preview" style="background: #f7f7f7; display: flex; align-items: center; justify-content: center; height: 233px;">
                        <i class="bi bi-clock-history" style="font-size: 48px; color: #ccc;"></i>
                    </div>
                    <div class="post-wrapper">
                        <div class="post-header text-center">
                            <h2 class="post-title text-muted">กำลังอัพเดตเร็ว ๆ นี้...</h2>
                        </div>
                        <div class="post-content text-center">
                            <p class="text-muted">รอข่าวสารและกิจกรรมเพิ่มเติมในอนาคต</p>
                        </div>
                        <div class="post-more"></div>
                    </div>
                </article>
            </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="space" data-MY="30px"></div>
                <a class="btn btn-circle btn-outline-brand" href="{{ route('news.index') }}">ดูข่าวสารทั้งหมด</a>
            </div>
        </div>
    </div>
</section>
<!-- Latest News end -->

    <!-- Contact Info / ช่องทางการติดต่อ -->
    <section class="module bg-gray" style="{{ $hl('contact') }}">
        <div class="container">
    <div class="row">
        <div class="col-md-6 m-auto text-center">
            <h1>ช่องทางการติดต่อเรา</h1>
            <p class="lead">เราพร้อมให้คำปรึกษาและบริการคุณตลอด 24 ชั่วโมง</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="space" data-MY="40px"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6">
            <div class="icon-box text-center">
                <div class="icon-box-icon"><i class="bi bi-telephone"></i></div>
                <div class="icon-box-title">
                    <h6>เบอร์โทรศัพท์</h6>
                </div>
                <div class="icon-box-content">
                    <p><a href="tel:0922569828">092-256-9828</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="icon-box text-center">
                <div class="icon-box-icon"><i class="bi bi-envelope"></i></div>
                <div class="icon-box-title">
                    <h6>อีเมล</h6>
                </div>
                <div class="icon-box-content">
                    <p><a href="mailto:pjs.legal2025@gmail.com">pjs.legal2025@gmail.com</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="icon-box text-center">
                <div class="icon-box-icon"><i class="bi bi-geo-alt"></i></div>
                <div class="icon-box-title">
                    <h6>ที่ตั้งบริษัท</h6>
                </div>
                <div class="icon-box-content">
                    <p>27/20 ซอยบางบอน4 ซอย4<br>แขวงบางบอนเหนือ เขตบางบอน<br>กรุงเทพมหานคร 10150</p>
                    <p><a href="https://maps.app.goo.gl/8ij4SHFibvKSEjkL8?g_st=il" target="_blank">ดูแผนที่</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
    <!-- Contact Info end -->

    <!-- Quick Contact / ปรึกษาคดีด่วน -->
    <section class="module" style="{{ $hl('quick_contact') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto text-center">
                    <h1>ปรึกษาคดีด่วน</h1>
                    <p class="lead">กรอกข้อมูลด้านล่างเพื่อให้ทีมงานของเราติดต่อกลับโดยเร็วที่สุด</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="40px"></div>
                </div>
            </div>
            <div class="row">
    <div class="col-md-8 m-auto">
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="ชื่อผู้ติดต่อ *" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" type="tel" name="phone" placeholder="เบอร์ติดต่อ *" value="{{ old('phone') }}" required>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="อีเมล" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" type="text" name="subject" placeholder="เรื่องที่ติดต่อ *" value="{{ old('subject') }}" required>
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="details" rows="5" placeholder="รายละเอียด *" required>{{ old('details') }}</textarea>
                @error('details')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-circle btn-brand" type="submit">ส่งข้อความ</button>
            </div>
        </form>
    </div>
</div>
        </div>
    </section>
    <!-- Quick Contact end -->

    <!-- Call to Action -->
    <section class="module parallax text-center" style="{{ $hl('cta') }}" data-background="{{ asset('frontend/images/module-12.jpg') }}" data-overlay="0.6">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-white m-b-20">พร้อมที่จะเริ่มต้นแล้วหรือยัง?</h2>
                    <p class="lead text-white m-b-40">ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี</p>
                    <p>
                        <a class="btn btn-lg btn-circle btn-brand" href="{{ route('contact.index') }}">ติดต่อเรา</a>
                        <a class="btn btn-lg btn-circle btn-outline-new-white" href="tel:0922569828">โทร 092-256-9828</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to Action end -->
    </div>
    <!-- /.home-sections -->

    <!-- Success/Error Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-5">
                    <div id="modal-icon" class="mb-4">
                        <!-- Icon จะถูกเพิ่มด้วย JavaScript -->
                    </div>
                    <h3 id="modal-title" class="mb-3"></h3>
                    <p id="modal-message" class="lead mb-4"></p>
                    <button type="button" class="btn btn-lg btn-circle btn-brand" id="modal-close-btn">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Success/Error Modal end -->

    @push('styles')
    <style>
        #contactModal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        #contactModal .modal-header {
            padding: 20px 20px 0 20px;
        }
        
        #contactModal .btn-close {
            font-size: 12px;
        }
        
        #contactModal .modal-body {
            padding: 40px;
        }
        
        #modal-icon i {
            animation: bounceIn 0.6s;
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
    @endpush

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ตัวแปร PHP ส่งมาจาก Laravel
    const hasSuccess = {{ session('success') ? 'true' : 'false' }};
    const hasError = {{ session('error') ? 'true' : 'false' }};
    const successMessage = {!! session('success') ? json_encode(session('success')) : 'null' !!};
    const errorMessage = {!! session('error') ? json_encode(session('error')) : 'null' !!};
    
    // แสดง Modal ตามเงื่อนไข
    if (hasSuccess && successMessage) {
        showContactModal('success', 'สำเร็จ!', successMessage);
    }
    
    if (hasError && errorMessage) {
        showContactModal('error', 'เกิดข้อผิดพลาด!', errorMessage);
    }
});

function showContactModal(type, title, message) {
    const modalElement = document.getElementById('contactModal');
    if (!modalElement) {
        console.error('Modal element not found');
        return;
    }
    
    const modal = new bootstrap.Modal(modalElement);
    const iconDiv = document.getElementById('modal-icon');
    const titleElement = document.getElementById('modal-title');
    const messageElement = document.getElementById('modal-message');
    const closeBtn = document.getElementById('modal-close-btn');
    
    // ตั้งค่า Icon และสี
    if (type === 'success') {
        iconDiv.innerHTML = '<i class="bi bi-check-circle-fill" style="font-size: 80px; color: #28a745;"></i>';
        titleElement.style.color = '#28a745';
        titleElement.textContent = title;
    } else {
        iconDiv.innerHTML = '<i class="bi bi-exclamation-circle-fill" style="font-size: 80px; color: #dc3545;"></i>';
        titleElement.style.color = '#dc3545';
        titleElement.textContent = title;
    }
    
    messageElement.textContent = message;
    
    // แสดง Modal
    modal.show();
    
    // ปุ่มตกลง - ปิด Modal
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.hide();
        };
    }
    
    // ปิดอัตโนมัติหลัง 3 วินาที
    setTimeout(function() {
        modal.hide();
    }, 3000);
    
    // เคลียร์ฟอร์มหลังส่งสำเร็จ
    if (type === 'success') {
        modalElement.addEventListener('hidden.bs.modal', function () {
            const form = document.querySelector('form[action="{{ route('contact.store') }}"]');
            if (form) {
                form.reset();
            }
        }, { once: true });
    }
}
	document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.team-swiper', {
      slidesPerView: 4,
      slidesPerGroup: 1,     // เลื่อนทีละ 1 card
      spaceBetween: 24,
      navigation: {
        nextEl: '.team-next',
        prevEl: '.team-prev'
      },
      breakpoints: {
        0:   { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        992: { slidesPerView: 4 }
      }
    });
  });
</script>
@endpush
@endsection