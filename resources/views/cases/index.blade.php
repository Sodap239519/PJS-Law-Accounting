@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ __('common.cases') }}</h2>
                <p>
                    @if(app()->getLocale() === 'th')
                        ผลงานและกรณีศึกษาที่ประสบความสำเร็จ
                    @else
                        Our successful case studies
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Portfolio -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if(isset($cases) && $cases->count() > 0)
                <div class="row">
                    @foreach($cases as $case)
                    <div class="col-md-6 m-b-30">
                        <article class="post">
                            <div class="post-preview">
                                <a href="{{ route('cases.show', $case) }}">
                                    @if($case->featured_image)
                                        <img src="{{ asset('storage/' . $case->featured_image) }}" alt="{{ $case->{'title_' . app()->getLocale()} }}">
                                    @else
                                        <img src="{{ asset('frontend/images/portfolio/default.jpg') }}" alt="{{ $case->{'title_' . app()->getLocale()} }}">
                                    @endif
                                </a>
                            </div>
                            <div class="post-wrapper">
                                <div class="post-header">
                                    <h2 class="post-title"><a href="{{ route('cases.show', $case) }}">{{ $case->{'title_' . app()->getLocale()} }}</a></h2>
                                    <ul class="post-meta">
                                        @if($case->category)
                                        <li><a href="{{ route('cases.index', ['category' => $case->category->id]) }}">{{ $case->category->{'name_' . app()->getLocale()} }}</a></li>
                                        @endif
                                        @if($case->client_name)
                                        <li>{{ $case->client_name }}</li>
                                        @endif
                                        <li>{{ $case->view_count }} {{ __('common.views') }}</li>
                                    </ul>
                                </div>
                                @if($case->{'challenge_' . app()->getLocale()})
                                <div class="post-content">
                                    <p>{{ Str::limit($case->{'challenge_' . app()->getLocale()}, 150) }}</p>
                                </div>
                                @endif
                                <div class="post-more"><a href="{{ route('cases.show', $case) }}">{{ __('common.read_more') }}</a></div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($cases->hasPages())
                <div class="pagination">
                    {{ $cases->links() }}
                </div>
                @endif
                @else
                <!-- Empty State -->
                <div class="text-center">
                    <div class="space" data-MY="60px"></div>
                    <h3>
                        @if(app()->getLocale() === 'th')
                            ไม่พบกรณีศึกษา
                        @else
                            No case studies found
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
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar">
                    <!-- Widget Categories -->
                    <div class="widget">
                        <h5 class="widget-title">{{ __('common.category') }}</h5>
                        <ul class="category-list">
                            <li>
                                <a href="{{ route('cases.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                    {{ __('common.all_categories') }}
                                </a>
                            </li>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('cases.index', ['category' => $category->id]) }}" class="{{ request('category') == $category->id ? 'active' : '' }}">
                                        {{ $category->{'name_' . app()->getLocale()} }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- Widget Categories end-->
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- Portfolio end-->
@endsection
