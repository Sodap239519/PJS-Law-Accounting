@extends('layouts.boomerang')

@section('title', __('common.home'))
@section('header-class', 'header-transparent')

@section('content')
    <!-- Hero-->
    <section class="module-cover parallax text-center fullscreen" data-background="{{ asset('frontend/images/module-2.jpg') }}" data-overlay="0.6">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="m-b-20">
                        <strong>
                            @if(app()->getLocale() === 'th')
                                ที่ปรึกษากฎหมายและบัญชีมืออาชีพ<br>เพื่อความสำเร็จของธุรกิจคุณ
                            @else
                                Professional Legal and Accounting Consultants<br>For Your Business Success
                            @endif
                        </strong>
                    </h1>
                    <p class="m-b-40">
                        @if(app()->getLocale() === 'th')
                            บริการให้คำปรึกษาด้านกฎหมายและบัญชีครบวงจร<br>ด้วยทีมงานมืออาชีพที่มีประสบการณ์
                        @else
                            Comprehensive legal and accounting consultation services<br>With experienced professional team
                        @endif
                    </p>
                    <p>
                        <a class="btn btn-lg btn-circle btn-brand" href="{{ route('contact.index') }}">{{ __('common.contact_us') }}</a>
                        <a class="btn btn-lg btn-circle btn-outline-new-white" href="{{ route('about.index') }}">
                            @if(app()->getLocale() === 'th')
                                เรียนรู้เพิ่มเติม
                            @else
                                Learn More
                            @endif
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero end-->

    <!-- About-->
    <section class="module divider-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto text-center">
                    <h1>{{ __('common.company_info.name') }}</h1>
                    <p class="lead">
                        @if(app()->getLocale() === 'th')
                            ให้บริการที่ปรึกษาด้านกฎหมายและบัญชีแก่ธุรกิจทุกประเภท ด้วยประสบการณ์และความเชี่ยวชาญ
                        @else
                            Providing legal and accounting consultation services to all types of businesses with experience and expertise
                        @endif
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="60px"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="icon-box">
                        <div class="icon-box-icon"><span class="ti-briefcase"></span></div>
                        <div class="icon-box-title">
                            <h6>
                                @if(app()->getLocale() === 'th')
                                    ที่ปรึกษากฎหมาย
                                @else
                                    Legal Consultation
                                @endif
                            </h6>
                        </div>
                        <div class="icon-box-content">
                            <p>
                                @if(app()->getLocale() === 'th')
                                    ให้คำปรึกษาด้านกฎหมายครอบคลุมทุกประเภท ทั้งกฎหมายแพ่ง อาญา แรงงาน และกฎหมายธุรกิจอื่นๆ
                                @else
                                    Comprehensive legal consultation covering all types including civil, criminal, labor and other business laws
                                @endif
                            </p>
                        </div>
                        <div class="icon-box-link"><a href="{{ route('about.legal') }}">{{ __('common.read_more') }}</a></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="icon-box">
                        <div class="icon-box-icon"><span class="ti-stats-up"></span></div>
                        <div class="icon-box-title">
                            <h6>
                                @if(app()->getLocale() === 'th')
                                    ที่ปรึกษาการบัญชี
                                @else
                                    Accounting Consultation
                                @endif
                            </h6>
                        </div>
                        <div class="icon-box-content">
                            <p>
                                @if(app()->getLocale() === 'th')
                                    บริการจดทะเบียนบริษัท จัดทำบัญชี ยื่นภาษี และวางแผนการเงินสำหรับธุรกิจของคุณ
                                @else
                                    Company registration, bookkeeping, tax filing and financial planning services for your business
                                @endif
                            </p>
                        </div>
                        <div class="icon-box-link"><a href="{{ route('about.accounting') }}">{{ __('common.read_more') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About end-->

    <!-- Services-->
    <section class="module bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto text-center">
                    <h1>
                        @if(app()->getLocale() === 'th')
                            บริการของเรา
                        @else
                            Our Services
                        @endif
                    </h1>
                    <p class="lead">
                        @if(app()->getLocale() === 'th')
                            เรามีบริการที่หลากหลายเพื่อตอบสนองความต้องการของธุรกิจคุณ
                        @else
                            We offer a wide range of services to meet your business needs
                        @endif
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="40px"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box text-center">
                        <div class="icon-box-icon"><span class="ti-write"></span></div>
                        <div class="icon-box-title">
                            <h6>
                                @if(app()->getLocale() === 'th')
                                    จดทะเบียนบริษัท
                                @else
                                    Company Registration
                                @endif
                            </h6>
                        </div>
                        <div class="icon-box-content">
                            <p>
                                @if(app()->getLocale() === 'th')
                                    รับจดทะเบียนบริษัท ห้างหุ้นส่วน และธุรกิจทุกประเภท
                                @else
                                    Registration of companies, partnerships and all types of businesses
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box text-center">
                        <div class="icon-box-icon"><span class="ti-receipt"></span></div>
                        <div class="icon-box-title">
                            <h6>
                                @if(app()->getLocale() === 'th')
                                    จัดทำบัญชีและภาษี
                                @else
                                    Accounting & Tax
                                @endif
                            </h6>
                        </div>
                        <div class="icon-box-content">
                            <p>
                                @if(app()->getLocale() === 'th')
                                    บริการจัดทำบัญชี ยื่นภาษี และตรวจสอบบัญชี
                                @else
                                    Bookkeeping, tax filing and auditing services
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box text-center">
                        <div class="icon-box-icon"><span class="ti-bookmark-alt"></span></div>
                        <div class="icon-box-title">
                            <h6>
                                @if(app()->getLocale() === 'th')
                                    ที่ปรึกษากฎหมาย
                                @else
                                    Legal Advisory
                                @endif
                            </h6>
                        </div>
                        <div class="icon-box-content">
                            <p>
                                @if(app()->getLocale() === 'th')
                                    ให้คำปรึกษาด้านกฎหมายและดำเนินคดี
                                @else
                                    Legal consultation and litigation services
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services end-->

    <!-- Latest News-->
    @if(isset($latestNews) && $latestNews->count() > 0)
    <section class="module">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto text-center">
                    <h1>{{ __('common.news') }}</h1>
                    <p class="lead">
                        @if(app()->getLocale() === 'th')
                            ข่าวสารและกิจกรรมล่าสุดของเรา
                        @else
                            Latest news and activities
                        @endif
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="space" data-MY="40px"></div>
                </div>
            </div>
            <div class="row">
                @foreach($latestNews as $news)
                <div class="col-md-4">
                    <article class="post">
                        <div class="post-preview">
                            @if($news->featured_image)
                                <a href="{{ route('news.show', $news->slug) }}">
                                    <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->{'title_' . app()->getLocale()} }}">
                                </a>
                            @else
                                <a href="{{ route('news.show', $news->slug) }}">
                                    <img src="{{ asset('frontend/images/module-18.jpg') }}" alt="{{ $news->{'title_' . app()->getLocale()} }}">
                                </a>
                            @endif
                        </div>
                        <div class="post-wrapper">
                            <div class="post-header">
                                <h2 class="post-title"><a href="{{ route('news.show', $news->slug) }}">{{ $news->{'title_' . app()->getLocale()} }}</a></h2>
                                <div class="post-meta">{{ $news->published_at->format('F d, Y') }}</div>
                            </div>
                            <div class="post-content">
                                <p>{{ Str::limit($news->{'excerpt_' . app()->getLocale()} ?? strip_tags($news->{'content_' . app()->getLocale()}), 120) }}</p>
                            </div>
                            <div class="post-more"><a href="{{ route('news.show', $news->slug) }}">{{ __('common.read_more') }}</a></div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="space" data-MY="30px"></div>
                    <a class="btn btn-circle btn-outline-brand" href="{{ route('news.index') }}">{{ __('common.view_all') }}</a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Latest News end-->

    <!-- Call to Action-->
    <section class="module bg-gray p-t-0 p-b-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="callout-text">
                        <h4>
                            @if(app()->getLocale() === 'th')
                                พร้อมที่จะเริ่มต้นแล้วหรือยัง?
                            @else
                                Ready to Get Started?
                            @endif
                        </h4>
                        <p>
                            @if(app()->getLocale() === 'th')
                                ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี
                            @else
                                Contact us today for a free consultation
                            @endif
                        </p>
                    </div>
                    <div class="callout-btn-box"><a class="btn btn-lg btn-circle btn-brand" href="{{ route('contact.index') }}">{{ __('common.contact_us') }}</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to Action end-->
@endsection
