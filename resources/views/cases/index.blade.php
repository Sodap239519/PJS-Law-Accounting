@extends('layouts.frontend')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ __('common.cases') }}</h1>
            <p class="text-xl text-gray-300">
                @if(app()->getLocale() === 'th')
                    ผลงานและกรณีศึกษาที่ประสบความสำเร็จ
                @else
                    Our successful case studies
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
                            <a href="{{ route('cases.index') }}" 
                               class="block px-4 py-2 rounded {{ !request('category') ? 'bg-pjs-gold text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ __('common.all_categories') }}
                            </a>
                        </li>
                        @if(isset($categories))
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('cases.index', ['category' => $category->id]) }}" 
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
                @if(isset($cases) && $cases->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cases as $case)
                    <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                        <!-- Featured Image -->
                        <div class="relative">
                            @if($case->featured_image)
                                <img src="{{ asset('storage/' . $case->featured_image) }}" 
                                     alt="{{ $case->{'title_' . app()->getLocale()} }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-pjs-gold to-pjs-blue flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            @if($case->category)
                            <div class="absolute top-4 left-4">
                                <span class="inline-block px-3 py-1 bg-pjs-blue text-white text-xs font-semibold rounded-full">
                                    {{ $case->category->{'name_' . app()->getLocale()} }}
                                </span>
                            </div>
                            @endif

                            @if(!$case->is_confidential && $case->client_name)
                            <div class="absolute bottom-4 left-4">
                                <span class="inline-block px-3 py-1 bg-white/90 text-pjs-blue text-xs font-semibold rounded-full">
                                    {{ $case->client_name }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-pjs-blue mb-3 line-clamp-2 min-h-[3.5rem]">
                                {{ $case->{'title_' . app()->getLocale()} }}
                            </h3>

                            @if($case->{'challenge_' . app()->getLocale()})
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-pjs-gold mb-1">
                                    @if(app()->getLocale() === 'th')
                                        ความท้าทาย:
                                    @else
                                        Challenge:
                                    @endif
                                </h4>
                                <p class="text-gray-600 text-sm line-clamp-3">
                                    {{ Str::limit($case->{'challenge_' . app()->getLocale()}, 150) }}
                                </p>
                            </div>
                            @endif

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $case->view_count }}
                                </span>
                                <a href="{{ route('cases.show', $case) }}" 
                                   class="inline-flex items-center text-pjs-gold hover:text-pjs-gold-dark font-semibold transition">
                                    {{ __('common.read_more') }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($cases->hasPages())
                <div class="mt-12">
                    {{ $cases->links() }}
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        @if(app()->getLocale() === 'th')
                            ไม่พบกรณีศึกษา
                        @else
                            No case studies found
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
