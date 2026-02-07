@extends('layouts.frontend')

@section('content')
<!-- Hero Image -->
<div class="relative h-96 bg-gray-900 overflow-hidden">
    @if($news->featured_image)
        <img src="{{ asset('storage/' . $news->featured_image) }}" 
             alt="{{ $news->{'title_' . app()->getLocale()} }}" 
             class="w-full h-full object-cover opacity-60">
    @else
        <div class="w-full h-full bg-gradient-to-br from-pjs-blue via-pjs-blue-dark to-pjs-gold opacity-80"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
</div>

<!-- Article Content -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-10 pb-16">
    <article class="bg-white rounded-lg shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="p-8 md:p-12">
            <!-- Category Badge -->
            @if($news->category)
            <div class="mb-4">
                <span class="inline-block px-4 py-1 bg-pjs-gold text-white text-sm font-semibold rounded-full">
                    {{ $news->category->{'name_' . app()->getLocale()} }}
                </span>
            </div>
            @endif

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-pjs-blue mb-6">
                {{ $news->{'title_' . app()->getLocale()} }}
            </h1>

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-8 pb-8 border-b border-gray-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ __('common.published_on') }}: {{ $news->published_at->format('d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>{{ $news->view_count }} {{ __('common.views') }}</span>
                </div>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($news->{'content_' . app()->getLocale()})) !!}
            </div>
        </div>

        <!-- Back Button -->
        <div class="px-8 md:px-12 pb-8">
            <a href="{{ route('news.index') }}" 
               class="inline-flex items-center text-pjs-blue hover:text-pjs-gold font-semibold transition">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                @if(app()->getLocale() === 'th')
                    กลับไปหน้าข่าว
                @else
                    Back to News
                @endif
            </a>
        </div>
    </article>

    <!-- Related News -->
    @if(isset($relatedNews) && $relatedNews->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl md:text-3xl font-bold text-pjs-blue mb-8">
            @if(app()->getLocale() === 'th')
                ข่าวที่เกี่ยวข้อง
            @else
                Related News
            @endif
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedNews as $related)
            <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                <div class="h-40 bg-gray-200">
                    @if($related->featured_image)
                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                             alt="{{ $related->{'title_' . app()->getLocale()} }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-pjs-blue to-pjs-gold flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-pjs-blue mb-2 line-clamp-2">
                        {{ $related->{'title_' . app()->getLocale()} }}
                    </h3>
                    <a href="{{ route('news.show', $related) }}" 
                       class="text-pjs-gold hover:text-pjs-gold-dark text-sm font-semibold inline-flex items-center">
                        {{ __('common.read_more') }}
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
