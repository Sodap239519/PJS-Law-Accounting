@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-pjs-blue via-pjs-blue-dark to-pjs-blue-light overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                {{ __('common.company_info.name') }}
            </h1>
            <p class="text-xl md:text-2xl text-pjs-gold-light mb-8 font-light">
                @if(app()->getLocale() === 'th')
                    ความเชี่ยวชาญเหนือระดับ เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย<br>เพื่อทุกความสำเร็จของคุณและธุรกิจ
                @else
                    Excellence Beyond Standards, Simplifying Legal Matters<br>For Your Success and Business Growth
                @endif
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-pjs-blue bg-pjs-gold hover:bg-pjs-gold-light transition duration-150">
                    {{ __('common.contact_us') }}
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <a href="{{ route('cases.index') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-pjs-blue transition duration-150">
                    {{ __('common.cases') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- About Legal Services Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-block px-4 py-1 bg-pjs-gold/10 rounded-full mb-4">
                    <span class="text-pjs-gold font-semibold text-sm">
                        @if(app()->getLocale() === 'th')
                            บริการด้านกฎหมาย
                        @else
                            Legal Services
                        @endif
                    </span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-pjs-blue mb-6">
                    @if(app()->getLocale() === 'th')
                        ที่ปรึกษากฎหมาย
                    @else
                        Legal Consultation
                    @endif
                </h2>
                <div class="prose prose-lg text-gray-600">
                    @if(app()->getLocale() === 'th')
                        <p>PJS ให้บริการให้คำปรึกษาด้านกฎหมาย ครอบคลุมทุกประเภทของกฎหมายที่เกี่ยวข้องกับธุรกิจ ไม่ว่าจะเป็นกฎหมายแพ่ง กฎหมายอาญา กฎหมายแรงงาน และกฎหมายอื่น ๆ ที่เกี่ยวข้องกับการดำเนินธุรกิจ</p>
                        
                        <p>ทีมงานของเรามีประสบการณ์ในการให้คำปรึกษาแก่บริษัทขนาดเล็ก ขนาดกลาง และขนาดใหญ่ ทั้งในและต่างประเทศ ช่วยให้ธุรกิจของคุณดำเนินการได้อย่างถูกต้องตามกฎหมาย และลดความเสี่ยงทางกฎหมาย</p>
                        
                        <p>เรามุ่งมั่นที่จะให้คำแนะนำที่ชัดเจน เข้าใจง่าย และสามารถนำไปปรับใช้ได้จริง เพื่อให้คุณสามารถตัดสินใจทางธุรกิจได้อย่างมั่นใจ</p>
                    @else
                        <p>PJS provides comprehensive legal consultation covering all types of business-related laws, including civil law, criminal law, labor law, and other relevant business regulations.</p>
                        
                        <p>Our team has extensive experience advising small, medium, and large enterprises, both domestic and international, helping your business operate legally and reduce legal risks.</p>
                        
                        <p>We are committed to providing clear, easy-to-understand, and actionable advice so you can make confident business decisions.</p>
                    @endif
                </div>
            </div>
            <div class="relative">
                <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden shadow-2xl">
                    <div class="w-full h-96 bg-gradient-to-br from-pjs-blue to-pjs-blue-light flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-pjs-gold/20 rounded-lg -z-10"></div>
            </div>
        </div>
    </div>
</div>

<!-- About Accounting Services Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1 relative">
                <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden shadow-2xl">
                    <div class="w-full h-96 bg-gradient-to-br from-pjs-gold to-pjs-gold-light flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="absolute -bottom-6 -left-6 w-48 h-48 bg-pjs-blue/20 rounded-lg -z-10"></div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="inline-block px-4 py-1 bg-pjs-blue/10 rounded-full mb-4">
                    <span class="text-pjs-blue font-semibold text-sm">
                        @if(app()->getLocale() === 'th')
                            บริการด้านการบัญชี
                        @else
                            Accounting Services
                        @endif
                    </span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-pjs-blue mb-6">
                    @if(app()->getLocale() === 'th')
                        ที่ปรึกษาการบัญชี
                    @else
                        Accounting Consultation
                    @endif
                </h2>
                <div class="prose prose-lg text-gray-600">
                    @if(app()->getLocale() === 'th')
                        <p>PJS ให้บริการที่ปรึกษาด้านการบัญชี ครอบคลุมทุกความต้องการของธุรกิจ ตั้งแต่การจดทะเบียนบริษัท การจัดทำบัญชี การยื่นภาษี ไปจนถึงการวางแผนทางการเงิน</p>
                        
                        <p>เรามีทีมนักบัญชีมืออาชีพที่มีประสบการณ์ในการให้บริการแก่ธุรกิจหลากหลายประเภท ทั้งธุรกิจขนาดเล็ก SMEs และบริษัทขนาดใหญ่ ช่วยให้คุณจัดการบัญชีและภาษีได้อย่างถูกต้องและมีประสิทธิภาพ</p>
                        
                        <p>เราเข้าใจว่าการบัญชีและภาษีเป็นเรื่องที่ซับซ้อน ดังนั้นเราจึงมุ่งเน้นให้บริการที่เข้าใจง่าย ชัดเจน และสามารถติดตามได้ตลอดเวลา เพื่อให้คุณมั่นใจได้ว่าธุรกิจของคุณดำเนินการได้อย่างถูกต้องตามกฎหมาย</p>
                    @else
                        <p>PJS provides comprehensive accounting consultation services covering all business needs, from company registration, bookkeeping, tax filing, to financial planning.</p>
                        
                        <p>We have a team of professional accountants experienced in serving various types of businesses, from small businesses and SMEs to large corporations, helping you manage accounting and taxes accurately and efficiently.</p>
                        
                        <p>We understand that accounting and taxation can be complex, so we focus on providing services that are easy to understand, clear, and can be monitored at all times, giving you confidence that your business operates in compliance with the law.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured News Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-pjs-blue mb-2">{{ __('common.news') }}</h2>
                <p class="text-gray-600">
                    @if(app()->getLocale() === 'th')
                        ข่าวสารและกิจกรรมล่าสุดของเรา
                    @else
                        Latest news and activities
                    @endif
                </p>
            </div>
            <a href="{{ route('news.index') }}" class="text-pjs-gold hover:text-pjs-gold-dark font-semibold flex items-center">
                {{ __('common.view_all') }}
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if(isset($latestNews) && $latestNews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestNews as $news)
            <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                    @if($news->featured_image)
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->{'title_' . app()->getLocale()} }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-pjs-blue to-pjs-gold flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                        <span>{{ $news->published_at->format('d M Y') }}</span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $news->view_count }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-pjs-blue mb-2 line-clamp-2">
                        {{ $news->{'title_' . app()->getLocale()} }}
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $news->{'excerpt_' . app()->getLocale()} ?? Str::limit(strip_tags($news->{'content_' . app()->getLocale()}), 150) }}
                    </p>
                    <a href="{{ route('news.show', $news) }}" class="text-pjs-gold hover:text-pjs-gold-dark font-semibold inline-flex items-center">
                        {{ __('common.read_more') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <p class="mt-2 text-gray-500">
                @if(app()->getLocale() === 'th')
                    ยังไม่มีข่าวสาร
                @else
                    No news available
                @endif
            </p>
        </div>
        @endif
    </div>
</div>

<!-- Call to Action -->
<div class="bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            @if(app()->getLocale() === 'th')
                พร้อมที่จะเริ่มต้นแล้วหรือยัง?
            @else
                Ready to Get Started?
            @endif
        </h2>
        <p class="text-xl text-gray-300 mb-8">
            @if(app()->getLocale() === 'th')
                ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรี
            @else
                Contact us today for a free consultation
            @endif
        </p>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-pjs-blue bg-pjs-gold hover:bg-pjs-gold-light transition duration-150">
            {{ __('common.contact_us') }}
            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
</div>
@endsection
