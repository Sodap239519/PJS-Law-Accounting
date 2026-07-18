@extends('layouts.boomerang')

@section('title', $case->title . ' - PJS กฎหมายและการบัญชี')

@section('content')
@php($cover = $case->getFirstMediaUrl('cover'))
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ $cover ?: asset('frontend/images/module-17.jpg') }}" data-overlay="0.55" style="padding:120px 0 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="m-b-10">{{ $case->title }}</h1>
                <ul class="post-meta" style="justify-content:center;">
                    @if($case->client_name)<li><i class="bi bi-person"></i> {{ $case->client_name }}</li>@endif
                    @if($case->category)<li><i class="bi bi-tag"></i> {{ $case->category->name }}</li>@endif
                    <li><i class="bi bi-eye"></i> {{ $case->views }}</li>
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
                            {!! $case->content !!}
                        </div>

                        @if($case->getMedia('gallery')->count())
                        <div class="rich-gallery">
                            @foreach($case->getMedia('gallery') as $img)
                                <a href="{{ $img->getUrl() }}" data-fancybox="gallery">
                                    <img src="{{ $img->getUrl() }}" alt="{{ $case->title }}" loading="lazy">
                                </a>
                            @endforeach
                        </div>
                        @endif

                        @if($case->getMedia('attachments')->count())
                        <div class="rich-files">
                            <h6><i class="bi bi-paperclip"></i> ไฟล์แนบ</h6>
                            @foreach($case->getMedia('attachments') as $file)
                                <a href="{{ $file->getUrl() }}" target="_blank" class="rich-file">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                    <span>{{ $file->file_name }}</span>
                                    <small>{{ number_format($file->size / 1024, 0) }} KB</small>
                                </a>
                            @endforeach
                        </div>
                        @endif

                        @if($case->links && $case->links->count())
                        <div class="rich-files">
                            <h6><i class="bi bi-link-45deg"></i> ลิงก์ที่เกี่ยวข้อง</h6>
                            @foreach($case->links as $link)
                                <a href="{{ $link->url }}" target="_blank" class="rich-file">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                    <span>{{ $link->label ?: $link->url }}</span>
                                </a>
                            @endforeach
                        </div>
                        @endif

                        <div class="post-nav m-t-40">
                            <a href="{{ route('cases.index') }}" class="btn btn-border-d btn-circle"><i class="bi bi-arrow-left"></i> กลับไปหน้าคดีตัวอย่าง</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
