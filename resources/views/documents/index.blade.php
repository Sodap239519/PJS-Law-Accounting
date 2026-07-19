@extends('layouts.boomerang')

@section('title', 'เอกสารดาวน์โหลด - PJS กฎหมายและการบัญชี')

@php
    function pjsFileIcon($ext) {
        $ext = strtolower($ext);
        return match(true) {
            in_array($ext, ['pdf']) => ['bi bi-file-earmark-pdf', '#e11d48'],
            in_array($ext, ['doc','docx']) => ['bi bi-file-earmark-word', '#2563eb'],
            in_array($ext, ['xls','xlsx']) => ['bi bi-file-earmark-excel', '#16a34a'],
            in_array($ext, ['ppt','pptx']) => ['bi bi-file-earmark-ppt', '#ea580c'],
            in_array($ext, ['jpg','jpeg','png','gif','webp']) => ['bi bi-file-earmark-image', '#7c3aed'],
            default => ['bi bi-file-earmark', '#64748b'],
        };
    }
@endphp

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-17.jpg') }}" data-overlay="0.45" style="padding:120px 0 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-b-10">เอกสารดาวน์โหลด</h2>
                <p class="lead">เอกสารและแบบฟอร์มที่จำเป็นสำหรับคุณ</p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end -->

<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($documents->count())
                <div class="pjs-doc-list">
                    @foreach($documents as $doc)
                        @php($media = $doc->getFirstMedia('file'))
                        @php([$ic, $color] = pjsFileIcon($media?->extension ?? ''))
                        <div class="pjs-doc-item">
                            <span class="pjs-doc-icon" style="color:{{ $color }}"><i class="{{ $ic }}"></i></span>
                            <div class="pjs-doc-body">
                                <h5>{{ $doc->title }}</h5>
                                @if($doc->description)<p>{{ $doc->description }}</p>@endif
                                <div class="pjs-doc-meta">
                                    @if($doc->category)<span><i class="bi bi-tag"></i> {{ $doc->category->name }}</span>@endif
                                    @if($media)<span><i class="bi bi-hdd"></i> {{ number_format($media->size / 1024, 0) }} KB</span>@endif
                                    <span><i class="bi bi-download"></i> {{ $doc->downloads }} ครั้ง</span>
                                </div>
                            </div>
                            @if($media)
                            <a href="{{ route('documents.download', $doc->id) }}" class="pjs-doc-btn"><i class="bi bi-download"></i> ดาวน์โหลด</a>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($documents->hasPages())
                <div class="m-t-30">{{ $documents->links() }}</div>
                @endif
                @else
                <div class="text-center p-y-60">
                    <i class="bi bi-folder2-open" style="font-size:56px;color:#cbd5e1"></i>
                    <h4 class="m-t-20">ยังไม่มีเอกสาร</h4>
                    <p class="text-muted">กรุณากลับมาตรวจสอบอีกครั้งในภายหลัง</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar">
                    <div class="widget">
                        <h5 class="widget-title">หมวดหมู่</h5>
                        <ul class="category-list">
                            <li><a href="{{ route('documents.index') }}" class="{{ !request('category') ? 'active' : '' }}">ทั้งหมด</a></li>
                            @foreach($categories as $category)
                            <li><a href="{{ route('documents.index', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<style>
    .pjs-doc-list { display: flex; flex-direction: column; gap: 14px; }
    .pjs-doc-item {
        display: flex; align-items: center; gap: 16px;
        background: #fff; border: 1px solid #eef2f7; border-radius: 14px;
        padding: 16px 18px; transition: all .2s; box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .pjs-doc-item:hover { border-color: #d4af37; box-shadow: 0 6px 20px rgba(0,0,0,.08); }
    .pjs-doc-icon { font-size: 40px; flex: 0 0 auto; line-height: 1; }
    .pjs-doc-body { flex: 1 1 auto; min-width: 0; }
    .pjs-doc-body h5 { margin: 0 0 4px; font-weight: 600; color: #1f2937; }
    .pjs-doc-body p { margin: 0 0 6px; color: #6b7280; font-size: .95em; }
    .pjs-doc-meta { display: flex; flex-wrap: wrap; gap: 14px; font-size: .85em; color: #94a3b8; }
    .pjs-doc-btn {
        flex: 0 0 auto; background: linear-gradient(135deg,#d4af37,#b8942f); color: #fff !important;
        padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 500; white-space: nowrap;
    }
    .pjs-doc-btn:hover { filter: brightness(1.05); color: #fff; }
    @media (max-width: 575px) {
        .pjs-doc-item { flex-wrap: wrap; }
        .pjs-doc-btn { width: 100%; text-align: center; }
    }
</style>
@endsection
