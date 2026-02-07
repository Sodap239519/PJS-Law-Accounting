@extends('layouts.frontend')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ __('common.team') }}</h1>
            <p class="text-xl text-gray-300">
                @if(app()->getLocale() === 'th')
                    ทีมงานมืออาชีพที่พร้อมให้บริการ
                @else
                    Professional team ready to serve you
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Team Members Grid -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($teamMembers as $member)
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                <!-- Photo -->
                <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-pjs-blue to-pjs-gold">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" 
                             alt="{{ $member->{'name_' . app()->getLocale()} }}" 
                             class="w-full h-80 object-cover">
                    @else
                        <div class="w-full h-80 bg-gradient-to-br from-pjs-blue to-pjs-gold flex items-center justify-center">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-pjs-blue mb-1">
                        {{ $member->{'name_' . app()->getLocale()} }}
                    </h3>
                    <p class="text-pjs-gold font-semibold mb-3">
                        {{ $member->{'position_' . app()->getLocale()} }}
                    </p>
                    
                    @if($member->{'bio_' . app()->getLocale()})
                    <p class="text-gray-600 text-sm line-clamp-4">
                        {{ $member->{'bio_' . app()->getLocale()} }}
                    </p>
                    @endif

                    @if($member->email || $member->phone)
                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                        @if($member->email)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $member->email }}" class="hover:text-pjs-gold">{{ $member->email }}</a>
                        </div>
                        @endif

                        @if($member->phone)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ $member->phone }}" class="hover:text-pjs-gold">{{ $member->phone }}</a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-200 rounded-full mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                @if(app()->getLocale() === 'th')
                    ยังไม่มีข้อมูลทีมงาน
                @else
                    No team members yet
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
    </div>
</div>

<!-- Call to Action -->
<div class="bg-pjs-blue py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    @if(app()->getLocale() === 'th')
                        สนใจปรึกษาทีมงานของเรา?
                    @else
                        Interested in consulting with our team?
                    @endif
                </h2>
                <p class="text-gray-300">
                    @if(app()->getLocale() === 'th')
                        ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี
                    @else
                        Contact us today for a free consultation
                    @endif
                </p>
            </div>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-pjs-blue bg-pjs-gold hover:bg-pjs-gold-light transition duration-150">
                {{ __('common.contact_us') }}
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
