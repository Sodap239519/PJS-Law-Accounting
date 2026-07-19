@extends('layouts.boomerang')

@section('title', 'คดีตัวอย่าง - PJS กฎหมายและการบัญชี')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.4" style="padding:120px 0 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-b-10">คดีตัวอย่าง</h2>
                <p class="lead">ผลงานและกรณีศึกษาที่ประสบความสำเร็จ</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if(isset($cases) && $cases->count() > 0)
                <div class="row">
                    @foreach($cases as $case)
                    <div class="col-md-6 m-b-30">
                        <article class="post h-100">
                            @if($case->getFirstMediaUrl('cover'))
                            <div class="post-preview">
                                <a href="{{ route('cases.show', $case->slug) }}">
                                    <img src="{{ $case->getFirstMediaUrl('cover') }}" alt="{{ $case->title }}" style="aspect-ratio:16/9;object-fit:cover;width:100%;border-radius:10px;">
                                </a>
                            </div>
                            @endif
                            <div class="post-wrapper">
                                <div class="post-header">
                                    <ul class="post-meta">
                                        @if($case->category)<li><i class="bi bi-tag"></i> {{ $case->category->name }}</li>@endif
                                        @if($case->client_name)<li><i class="bi bi-person"></i> {{ $case->client_name }}</li>@endif
                                    </ul>
                                    <h5 class="post-title"><a href="{{ route('cases.show', $case->slug) }}">{{ $case->title }}</a></h5>
                                </div>
                                <div class="post-content">
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($case->content), 120) }}</p>
                                </div>
                                <div class="post-more"><a href="{{ route('cases.show', $case->slug) }}">อ่านเพิ่มเติม <i class="bi bi-arrow-right"></i></a></div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                @if($cases->hasPages())
                <div class="m-t-20">{{ $cases->links() }}</div>
                @endif
                @else
                <div class="text-center p-y-60">
                    <h3>ไม่พบคดีตัวอย่าง</h3>
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
                            <li><a href="{{ route('cases.index') }}" class="{{ !request('category') ? 'active' : '' }}">ทั้งหมด</a></li>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                <li><a href="{{ route('cases.index', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<style>
    /* จำกัดจำนวนบรรทัดให้การ์ดสูงเท่ากัน — ระยะห่างจะสม่ำเสมอ */
    .post .post-title { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:2.6em; }
    .post .post-content p { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endsection
