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
        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="row">
            @foreach($teamMembers as $member)
            <div class="col-md-4">
                <div class="team-item">
                    <div class="team-image">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->{'name_' . app()->getLocale()} }}">
                        @else
                            <img src="{{ asset('frontend/images/team/default.jpg') }}" alt="{{ $member->{'name_' . app()->getLocale()} }}">
                        @endif
                        <div class="team-wrap">
                            <div class="team-content">
                                <h6 class="team-name">{{ $member->{'name_' . app()->getLocale()} }}</h6>
                                <div class="team-role">{{ $member->{'position_' . app()->getLocale()} }}</div>
                            </div>
                            @if($member->email || $member->phone)
                            <div class="team-content-social">
                                <ul>
                                    @if($member->email)
                                    <li><a href="mailto:{{ $member->email }}"><i class="fas fa-envelope"></i></a></li>
                                    @endif
                                    @if($member->phone)
                                    <li><a href="tel:{{ $member->phone }}"><i class="fas fa-phone"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($member->{'bio_' . app()->getLocale()})
                    <div class="team-descr">
                        <p>{{ $member->{'bio_' . app()->getLocale()} }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="space" data-MY="60px"></div>
                <h3>
                    @if(app()->getLocale() === 'th')
                        ยังไม่มีข้อมูลทีมงาน
                    @else
                        No team members yet
                    @endif
                </h3>
                <p>
                    @if(app()->getLocale() === 'th')
                        กรุณากลับมาตรวจสอบอีกครั้งในภายหลัง
                    @else
                        Please check back later
                    @endif
                </p>
                <div class="space" data-MY="60px"></div>
            </div>
        </div>
        @endif
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
