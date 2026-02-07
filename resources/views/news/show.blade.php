@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ $news->featured_image ? asset('storage/' . $news->featured_image) : asset('frontend/images/module-17.jpg') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $news->{'title_' . app()->getLocale()} }}</h1>
                @if($news->category)
                <p class="lead">{{ $news->category->{'name_' . app()->getLocale()} }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Blog Single -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Post -->
                <article class="post">
                    <div class="post-wrapper">
                        <div class="post-header">
                            <h1 class="post-title">{{ $news->{'title_' . app()->getLocale()} }}</h1>
                            <ul class="post-meta">
                                <li>{{ __('common.published_on') }}: {{ $news->published_at->format('F d, Y') }}</li>
                                @if($news->category)
                                <li><a href="{{ route('news.index', ['category' => $news->category->id]) }}">{{ $news->category->{'name_' . app()->getLocale()} }}</a></li>
                                @endif
                                <li>{{ $news->view_count }} {{ __('common.views') }}</li>
                            </ul>
                        </div>
                        
                        @if($news->featured_image)
                        <div class="post-preview">
                            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->{'title_' . app()->getLocale()} }}">
                        </div>
                        @endif

                        <div class="post-content">
                            {!! nl2br(e($news->{'content_' . app()->getLocale()})) !!}
                        </div>

                        <div class="post-nav">
                            <a href="{{ route('news.index') }}" class="btn btn-border-d btn-circle">
                                @if(app()->getLocale() === 'th')
                                    กลับไปหน้าข่าว
                                @else
                                    Back to News
                                @endif
                            </a>
                        </div>
                    </div>
                </article>
                <!-- Post end-->

                <!-- Related News -->
                @if(isset($relatedNews) && $relatedNews->count() > 0)
                <div class="module">
                    <h4 class="m-b-30">
                        @if(app()->getLocale() === 'th')
                            ข่าวที่เกี่ยวข้อง
                        @else
                            Related News
                        @endif
                    </h4>
                    <div class="row">
                        @foreach($relatedNews as $related)
                        <div class="col-md-4">
                            <article class="post">
                                <div class="post-preview">
                                    <a href="{{ route('news.show', $related) }}">
                                        @if($related->featured_image)
                                            <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->{'title_' . app()->getLocale()} }}">
                                        @else
                                            <img src="{{ asset('frontend/images/blog/default.jpg') }}" alt="{{ $related->{'title_' . app()->getLocale()} }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="post-wrapper">
                                    <div class="post-header">
                                        <h6 class="post-title"><a href="{{ route('news.show', $related) }}">{{ $related->{'title_' . app()->getLocale()} }}</a></h6>
                                    </div>
                                    <div class="post-more"><a href="{{ route('news.show', $related) }}">{{ __('common.read_more') }}</a></div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
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
                                <a href="{{ route('news.index') }}">{{ __('common.all_categories') }}</a>
                            </li>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('news.index', ['category' => $category->id]) }}" class="{{ $news->category_id == $category->id ? 'active' : '' }}">
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
<!-- Blog Single end-->
@endsection
