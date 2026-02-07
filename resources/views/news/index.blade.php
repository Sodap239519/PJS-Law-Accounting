@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ __('common.news') }}</h2>
                <p>
                    @if(app()->getLocale() === 'th')
                        ข่าวสารและกิจกรรมของเรา
                    @else
                        Our news and activities
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Blog -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if(isset($news) && $news->count() > 0)
                    @foreach($news as $article)
                    <!-- Post -->
                    <article class="post">
                        <div class="post-preview">
                            <a href="{{ route('news.show', $article) }}">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->{'title_' . app()->getLocale()} }}">
                                @else
                                    <img src="{{ asset('frontend/images/blog/default.jpg') }}" alt="{{ $article->{'title_' . app()->getLocale()} }}">
                                @endif
                            </a>
                        </div>
                        <div class="post-wrapper">
                            <div class="post-header">
                                <h2 class="post-title"><a href="{{ route('news.show', $article) }}">{{ $article->{'title_' . app()->getLocale()} }}</a></h2>
                                <ul class="post-meta">
                                    <li>{{ $article->published_at->format('F d, Y') }}</li>
                                    @if($article->category)
                                    <li><a href="{{ route('news.index', ['category' => $article->category->id]) }}">{{ $article->category->{'name_' . app()->getLocale()} }}</a></li>
                                    @endif
                                    <li>{{ $article->view_count }} {{ __('common.views') }}</li>
                                </ul>
                            </div>
                            <div class="post-content">
                                <p>{{ $article->{'excerpt_' . app()->getLocale()} ?? Str::limit(strip_tags($article->{'content_' . app()->getLocale()}), 200) }}</p>
                            </div>
                            <div class="post-more"><a href="{{ route('news.show', $article) }}">{{ __('common.read_more') }}</a></div>
                        </div>
                    </article>
                    <!-- Post end-->
                    @endforeach

                    <!-- Pagination -->
                    @if($news->hasPages())
                    <div class="pagination">
                        {{ $news->links() }}
                    </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center">
                        <div class="space" data-MY="60px"></div>
                        <h3>
                            @if(app()->getLocale() === 'th')
                                ไม่พบข่าวสาร
                            @else
                                No news found
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
                                <a href="{{ route('news.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                    {{ __('common.all_categories') }}
                                </a>
                            </li>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('news.index', ['category' => $category->id]) }}" class="{{ request('category') == $category->id ? 'active' : '' }}">
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
<!-- Blog end-->
@endsection
