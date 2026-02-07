@extends('layouts.frontend')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ __('common.news') }}</h1>
            <p class="text-xl text-gray-300">
                @if(app()->getLocale() === 'th')
                    ข่าวสารและกิจกรรมของเรา
                @else
                    Our news and activities
                @endif
            </p>
        </div>
    </div>
</div>

<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar - Category Filter -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-pjs-blue mb-4">{{ __('common.category') }}</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('news.index') }}" 
                               class="block px-4 py-2 rounded {{ !request('category') ? 'bg-pjs-gold text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ __('common.all_categories') }}
                            </a>
                        </li>
                        @if(isset($categories))
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('news.index', ['category' => $category->id]) }}" 
                                   class="block px-4 py-2 rounded {{ request('category') == $category->id ? 'bg-pjs-gold text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $category->{'name_' . app()->getLocale()} }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                @if(isset($news) && $news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $article)
                    <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Featured Image -->
                        <div class="relative">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     alt="{{ $article->{'title_' . app()->getLocale()} }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-pjs-blue to-pjs-gold flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            @if($article->category)
                            <div class="absolute top-4 left-4">
                                <span class="inline-block px-3 py-1 bg-pjs-gold text-white text-xs font-semibold rounded-full">
                                    {{ $article->category->{'name_' . app()->getLocale()} }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $article->published_at->format('d M Y') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $article->view_count }} {{ __('common.views') }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-pjs-blue mb-3 line-clamp-2 min-h-[3.5rem]">
                                {{ $article->{'title_' . app()->getLocale()} }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $article->{'excerpt_' . app()->getLocale()} ?? Str::limit(strip_tags($article->{'content_' . app()->getLocale()}), 120) }}
                            </p>

                            <a href="{{ route('news.show', $article) }}" 
                               class="inline-flex items-center text-pjs-gold hover:text-pjs-gold-dark font-semibold transition">
                                {{ __('common.read_more') }}
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($news->hasPages())
                <div class="mt-12">
                    {{ $news->links() }}
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        @if(app()->getLocale() === 'th')
                            ไม่พบข่าวสาร
                        @else
                            No news found
                        @endif
                    </h3>
                    <p class="text-gray-600">
                        @if(app()->getLocale() === 'th')
                            กรุณากลับมาตรวจสอบอีกครั้งในภายหลัง
                        @else
                            Please check back later
                        @endif
                    </p>
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
