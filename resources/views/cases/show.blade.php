@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ $case->featured_image ? asset('storage/' . $case->featured_image) : asset('frontend/images/module-17.jpg') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $case->{'title_' . app()->getLocale()} }}</h1>
                @if($case->category)
                <p class="lead">{{ $case->category->{'name_' . app()->getLocale()} }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Case Study -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Case Info -->
                <div class="m-b-40">
                    <ul class="post-meta">
                        @if($case->client_name)
                        <li>
                            <strong>
                                @if(app()->getLocale() === 'th')
                                    ลูกค้า:
                                @else
                                    Client:
                                @endif
                            </strong>
                            {{ $case->client_name }}
                        </li>
                        @endif
                        @if($case->category)
                        <li>
                            <a href="{{ route('cases.index', ['category' => $case->category->id]) }}">{{ $case->category->{'name_' . app()->getLocale()} }}</a>
                        </li>
                        @endif
                        <li>{{ $case->view_count }} {{ __('common.views') }}</li>
                    </ul>
                </div>

                @if($case->featured_image)
                <div class="m-b-40">
                    <img src="{{ asset('storage/' . $case->featured_image) }}" alt="{{ $case->{'title_' . app()->getLocale()} }}">
                </div>
                @endif

                <h1 class="m-b-20">{{ $case->{'title_' . app()->getLocale()} }}</h1>

                <!-- Challenge Section -->
                @if($case->{'challenge_' . app()->getLocale()})
                <div class="m-b-40">
                    <h4 class="m-b-20">
                        @if(app()->getLocale() === 'th')
                            ความท้าทาย
                        @else
                            Challenge
                        @endif
                    </h4>
                    <p>{!! nl2br(e($case->{'challenge_' . app()->getLocale()})) !!}</p>
                </div>
                @endif

                <!-- Solution Section -->
                @if($case->{'solution_' . app()->getLocale()})
                <div class="m-b-40">
                    <h4 class="m-b-20">
                        @if(app()->getLocale() === 'th')
                            แนวทางแก้ไข
                        @else
                            Solution
                        @endif
                    </h4>
                    <p>{!! nl2br(e($case->{'solution_' . app()->getLocale()})) !!}</p>
                </div>
                @endif

                <!-- Result Section -->
                @if($case->{'result_' . app()->getLocale()})
                <div class="m-b-40">
                    <h4 class="m-b-20">
                        @if(app()->getLocale() === 'th')
                            ผลลัพธ์
                        @else
                            Result
                        @endif
                    </h4>
                    <p>{!! nl2br(e($case->{'result_' . app()->getLocale()})) !!}</p>
                </div>
                @endif

                <!-- Gallery Images -->
                @if(isset($case->gallery) && is_array($case->gallery) && count($case->gallery) > 0)
                <div class="m-b-40">
                    <h4 class="m-b-20">
                        @if(app()->getLocale() === 'th')
                            ภาพประกอบ
                        @else
                            Gallery
                        @endif
                    </h4>
                    <div class="row">
                        @foreach($case->gallery as $image)
                        <div class="col-md-4 m-b-30">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $case->{'title_' . app()->getLocale()} }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Back Button -->
                <div class="m-t-40">
                    <a href="{{ route('cases.index') }}" class="btn btn-border-d btn-circle">
                        @if(app()->getLocale() === 'th')
                            กลับไปหน้าผลงาน
                        @else
                            Back to Case Studies
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Case Study end-->
@endsection
