@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ __('common.team') }}</h2>
                <p>
                    @if(app()->getLocale() === 'th')
                        ทีมงานมืออาชีพที่พร้อมให้บริการ
                    @else
                        Professional team ready to serve you
                    @endif
                </p>
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
<section class="module bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="m-b-0">
                    @if(app()->getLocale() === 'th')
                        สนใจปรึกษาทีมงานของเรา?
                    @else
                        Interested in consulting with our team?
                    @endif
                </h3>
                <p class="lead m-b-0">
                    @if(app()->getLocale() === 'th')
                        ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี
                    @else
                        Contact us today for a free consultation
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-right">
                <a class="btn btn-white" href="{{ route('contact.index') }}">{{ __('common.contact_us') }}</a>
            </div>
        </div>
    </div>
</section>
<!-- Call to Action end-->
@endsection
