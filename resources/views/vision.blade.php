@extends('layouts.frontend')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-pjs-blue via-pjs-blue-dark to-black">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-pjs-gold opacity-20 rounded-full filter blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-pjs-gold-light opacity-10 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Logo/Icon -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-pjs-gold rounded-full mb-6 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
        </div>

        <!-- Vision Statement -->
        <div class="text-center space-y-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight px-4">
                <span class="inline-block mb-4 bg-gradient-to-r from-pjs-gold via-pjs-gold-light to-pjs-gold bg-clip-text text-transparent">
                    @if(app()->getLocale() === 'th')
                        ความเชี่ยวชาญเหนือระดับ
                    @else
                        Excellence Beyond Standards
                    @endif
                </span>
                <br>
                <span class="text-white">
                    @if(app()->getLocale() === 'th')
                        เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย
                    @else
                        Simplifying Legal Matters
                    @endif
                </span>
                <br>
                <span class="text-pjs-gold-light">
                    @if(app()->getLocale() === 'th')
                        เพื่อทุกความสำเร็จของคุณและธุรกิจ
                    @else
                        For Your Success and Business Growth
                    @endif
                </span>
            </h1>

            <div class="max-w-4xl mx-auto">
                <div class="h-1 w-32 bg-gradient-to-r from-transparent via-pjs-gold to-transparent mx-auto mb-8"></div>
                <p class="text-lg md:text-xl lg:text-2xl text-gray-300 leading-relaxed">
                    @if(app()->getLocale() === 'th')
                        เราเชื่อว่าทุกธุรกิจควรได้รับคำปรึกษาทางกฎหมายและการบัญชีที่มีคุณภาพ<br class="hidden sm:block">
                        ด้วยความเชี่ยวชาญและประสบการณ์ เราพร้อมเป็นพันธมิตรในทุกก้าวของความสำเร็จ
                    @else
                        We believe every business deserves quality legal and accounting consultation<br class="hidden sm:block">
                        With expertise and experience, we're ready to be your partner in every step to success
                    @endif
                </p>
            </div>

            <!-- Core Values -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 max-w-5xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-pjs-gold/30 hover:bg-white/20 transition duration-300">
                    <div class="w-16 h-16 bg-pjs-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        @if(app()->getLocale() === 'th')
                            ความเชี่ยวชาญ
                        @else
                            Expertise
                        @endif
                    </h3>
                    <p class="text-gray-300">
                        @if(app()->getLocale() === 'th')
                            ทีมงานผู้เชี่ยวชาญที่มีประสบการณ์สูง
                        @else
                            Highly experienced professional team
                        @endif
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-pjs-gold/30 hover:bg-white/20 transition duration-300">
                    <div class="w-16 h-16 bg-pjs-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        @if(app()->getLocale() === 'th')
                            ความรวดเร็ว
                        @else
                            Efficiency
                        @endif
                    </h3>
                    <p class="text-gray-300">
                        @if(app()->getLocale() === 'th')
                            บริการที่รวดเร็ว ตรงเวลา และมีประสิทธิภาพ
                        @else
                            Fast, timely, and efficient service
                        @endif
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-pjs-gold/30 hover:bg-white/20 transition duration-300">
                    <div class="w-16 h-16 bg-pjs-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        @if(app()->getLocale() === 'th')
                            ความไว้วางใจ
                        @else
                            Trust
                        @endif
                    </h3>
                    <p class="text-gray-300">
                        @if(app()->getLocale() === 'th')
                            พันธมิตรที่คุณสามารถไว้วางใจได้
                        @else
                            A partner you can truly trust
                        @endif
                    </p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
                <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-pjs-blue bg-pjs-gold hover:bg-pjs-gold-light transform hover:scale-105 transition duration-150 shadow-xl">
                    {{ __('common.contact_us') }}
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-medium rounded-md text-white hover:bg-white hover:text-pjs-blue transform hover:scale-105 transition duration-150">
                    {{ __('common.home') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0.3;
        }
    }
</style>
@endsection
