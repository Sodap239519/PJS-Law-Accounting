@extends('layouts.boomerang')

@section('title', 'ข่าวสารและกิจกรรม - PJS กฎหมายและการบัญชี')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.4" style="padding:120px 0 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-b-10">ข่าวสารและกิจกรรม</h2>
                <p class="lead">ข่าวสารและกิจกรรมของเรา</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if(isset($news) && $news->count() > 0)
                    <div class="row">
                        @foreach($news as $article)
                        <div class="col-md-6 m-b-30">
                            <article class="post h-100">
                                <div class="post-preview">
                                    <a href="{{ route('news.show', $article->slug) }}">
                                        <img src="{{ $article->getFirstMediaUrl('cover') ?: asset('frontend/images/blog/default.jpg') }}" alt="{{ $article->title }}" style="aspect-ratio:16/9;object-fit:cover;width:100%;border-radius:10px;">
                                    </a>
                                </div>
                                <div class="post-wrapper">
                                    <div class="post-header">
                                        <ul class="post-meta">
                                            <li><i class="bi bi-calendar3"></i> {{ optional($article->published_at)->format('d/m/Y') }}</li>
                                            @if($article->category)<li><i class="bi bi-tag"></i> {{ $article->category->name }}</li>@endif
                                        </ul>
                                        <h5 class="post-title"><a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a></h5>
                                    </div>
                                    <div class="post-content">
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?: $article->content), 120) }}</p>
                                    </div>
                                    <div class="post-more"><a href="{{ route('news.show', $article->slug) }}">อ่านเพิ่มเติม <i class="bi bi-arrow-right"></i></a></div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    @if($news->hasPages())
                    <div class="m-t-20">{{ $news->links() }}</div>
                    @endif
                @else
                    <div class="text-center p-y-60">
                        <h3>ไม่พบข่าวสาร</h3>
                        <p>กรุณากลับมาตรวจสอบอีกครั้งในภายหลัง</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar">
                    <div class="widget">
                        <h5 class="widget-title">หมวดหมู่</h5>
                        <ul class="category-list">
                            <li><a href="{{ route('news.index') }}" class="{{ !request('category') ? 'active' : '' }}">ทั้งหมด</a></li>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                <li><a href="{{ route('news.index', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
