@extends('layouts.boomerang')

@section('title', $news->title . ' - PJS กฎหมายและการบัญชี')

@section('content')
@php($cover = $news->getFirstMediaUrl('cover'))
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ $cover ?: asset('frontend/images/module-17.jpg') }}" data-overlay="0.55" style="padding:120px 0 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-b-10">{{ $news->title }}</h1>
                <ul class="post-meta" style="justify-content:center;">
                    @if($news->published_at)<li><i class="bi bi-calendar3"></i> {{ $news->published_at->format('d/m/Y') }}</li>@endif
                    @if($news->category)<li><i class="bi bi-tag"></i> {{ $news->category->name }}</li>@endif
                    <li><i class="bi bi-eye"></i> {{ $news->views }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <article class="post">
                    <div class="post-wrapper">
                        <div class="post-content rich-content">
                            {!! $news->content !!}
                        </div>

                        {{-- แกลเลอรีรูปภาพ --}}
                        @if($news->getMedia('gallery')->count())
                        <div class="rich-gallery">
                            @foreach($news->getMedia('gallery') as $img)
                                <a href="{{ $img->getUrl() }}" class="glightbox" data-gallery="gallery">
                                    <img src="{{ $img->getUrl() }}" alt="{{ $news->title }}" loading="lazy">
                                </a>
                            @endforeach
                        </div>
                        @endif

                        {{-- ไฟล์แนบ --}}
                        @if($news->getMedia('attachments')->count())
                        <div class="rich-files">
                            <h6><i class="bi bi-paperclip"></i> ไฟล์แนบ</h6>
                            @foreach($news->getMedia('attachments') as $file)
                                <a href="{{ $file->getUrl() }}" target="_blank" class="rich-file">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                    <span>{{ $file->file_name }}</span>
                                    <small>{{ number_format($file->size / 1024, 0) }} KB</small>
                                </a>
                            @endforeach
                        </div>
                        @endif

                        {{-- ลิงก์ที่เกี่ยวข้อง --}}
                        @if($news->links && $news->links->count())
                        <div class="rich-files">
                            <h6><i class="bi bi-link-45deg"></i> ลิงก์ที่เกี่ยวข้อง</h6>
                            @foreach($news->links as $link)
                                <a href="{{ $link->url }}" target="_blank" class="rich-file">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                    <span>{{ $link->label ?: $link->url }}</span>
                                </a>
                            @endforeach
                        </div>
                        @endif

                        <div class="post-nav m-t-40">
                            <a href="{{ route('news.index') }}" class="btn btn-border-d btn-circle"><i class="bi bi-arrow-left"></i> กลับไปหน้าข่าว</a>
                        </div>
                    </div>
                </article>

                @if(isset($relatedNews) && $relatedNews->count() > 0)
                <div class="module p-t-50">
                    <h4 class="m-b-30">ข่าวที่เกี่ยวข้อง</h4>
                    <div class="row">
                        @foreach($relatedNews as $related)
                        <div class="col-md-4 m-b-20">
                            <article class="post">
                                @if($related->getFirstMediaUrl('cover'))
                                <div class="post-preview">
                                    <a href="{{ route('news.show', $related->slug) }}">
                                        <img src="{{ $related->getFirstMediaUrl('cover') }}" alt="{{ $related->title }}" style="aspect-ratio:16/9;object-fit:cover;width:100%;border-radius:8px;">
                                    </a>
                                </div>
                                @endif
                                <div class="post-wrapper">
                                    <div class="post-header">
                                        <h6 class="post-title"><a href="{{ route('news.show', $related->slug) }}">{{ $related->title }}</a></h6>
                                    </div>
                                    <div class="post-more"><a href="{{ route('news.show', $related->slug) }}">อ่านเพิ่มเติม</a></div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
