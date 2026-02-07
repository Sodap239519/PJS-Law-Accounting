@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<div class="relative h-80 bg-gradient-to-r from-pjs-blue to-pjs-blue-dark overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    @if($case->featured_image)
    <img src="{{ asset('storage/' . $case->featured_image) }}" 
         alt="{{ $case->{'title_' . app()->getLocale()} }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-30">
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-12">
        <div>
            @if($case->category)
            <span class="inline-block px-4 py-1 bg-pjs-gold text-white text-sm font-semibold rounded-full mb-4">
                {{ $case->category->{'name_' . app()->getLocale()} }}
            </span>
            @endif
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white">
                {{ $case->{'title_' . app()->getLocale()} }}
            </h1>
        </div>
    </div>
</div>

<!-- Case Study Content -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Client Info & Meta -->
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
            <div class="flex flex-wrap items-center gap-6">
                @if($case->client_name)
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-gray-700">
                        <strong class="text-pjs-blue">
                            @if(app()->getLocale() === 'th')
                                ลูกค้า:
                            @else
                                Client:
                            @endif
                        </strong>
                        {{ $case->client_name }}
                    </span>
                </div>
                @endif

                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $case->view_count }} {{ __('common.views') }}
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12 space-y-8">
            <!-- Challenge Section -->
            @if($case->{'challenge_' . app()->getLocale()})
            <section>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pjs-blue rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-pjs-blue">
                        @if(app()->getLocale() === 'th')
                            ความท้าทาย
                        @else
                            Challenge
                        @endif
                    </h2>
                </div>
                <div class="prose prose-lg max-w-none text-gray-700 pl-16">
                    {!! nl2br(e($case->{'challenge_' . app()->getLocale()})) !!}
                </div>
            </section>
            @endif

            <!-- Solution Section -->
            @if($case->{'solution_' . app()->getLocale()})
            <section class="bg-gray-50 -mx-8 md:-mx-12 px-8 md:px-12 py-8 rounded-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pjs-gold rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-pjs-blue">
                        @if(app()->getLocale() === 'th')
                            แนวทางแก้ไข
                        @else
                            Solution
                        @endif
                    </h2>
                </div>
                <div class="prose prose-lg max-w-none text-gray-700 pl-16">
                    {!! nl2br(e($case->{'solution_' . app()->getLocale()})) !!}
                </div>
            </section>
            @endif

            <!-- Result Section -->
            @if($case->{'result_' . app()->getLocale()})
            <section>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-pjs-blue">
                        @if(app()->getLocale() === 'th')
                            ผลลัพธ์
                        @else
                            Result
                        @endif
                    </h2>
                </div>
                <div class="prose prose-lg max-w-none text-gray-700 pl-16">
                    {!! nl2br(e($case->{'result_' . app()->getLocale()})) !!}
                </div>
            </section>
            @endif

            <!-- Gallery Images -->
            @if(isset($case->gallery) && is_array($case->gallery) && count($case->gallery) > 0)
            <section class="pt-8">
                <h2 class="text-2xl md:text-3xl font-bold text-pjs-blue mb-6">
                    @if(app()->getLocale() === 'th')
                        ภาพประกอบ
                    @else
                        Gallery
                    @endif
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($case->gallery as $image)
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/' . $image) }}" 
                             alt="{{ $case->{'title_' . app()->getLocale()} }}" 
                             class="w-full h-64 object-cover hover:scale-110 transition duration-300">
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Back Button -->
        <div class="px-8 md:px-12 pb-8">
            <a href="{{ route('cases.index') }}" 
               class="inline-flex items-center text-pjs-blue hover:text-pjs-gold font-semibold transition">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                @if(app()->getLocale() === 'th')
                    กลับไปหน้าผลงาน
                @else
                    Back to Case Studies
                @endif
            </a>
        </div>
    </div>
</div>
@endsection
