@extends('layouts.frontend')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ __('common.downloads') }}</h1>
            <p class="text-xl text-gray-300">
                @if(app()->getLocale() === 'th')
                    เอกสารและแบบฟอร์มที่จำเป็นสำหรับคุณ
                @else
                    Essential documents and forms for you
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
                            <a href="{{ route('documents.index') }}" 
                               class="block px-4 py-2 rounded {{ !request('category') ? 'bg-pjs-gold text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ __('common.all_categories') }}
                            </a>
                        </li>
                        @if(isset($categories))
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('documents.index', ['category' => $category->id]) }}" 
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
                @if(isset($documents) && $documents->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pjs-blue">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        @if(app()->getLocale() === 'th')
                                            ชื่อเอกสาร
                                        @else
                                            Document Name
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        {{ __('common.category') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        @if(app()->getLocale() === 'th')
                                            ขนาดไฟล์
                                        @else
                                            File Size
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        {{ __('common.downloads_count') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-white uppercase tracking-wider">
                                        @if(app()->getLocale() === 'th')
                                            ดาวน์โหลด
                                        @else
                                            Download
                                        @endif
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($documents as $document)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg class="w-10 h-10 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-pjs-blue">
                                                    {{ $document->{'title_' . app()->getLocale()} }}
                                                </div>
                                                @if($document->{'description_' . app()->getLocale()})
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ Str::limit($document->{'description_' . app()->getLocale()}, 100) }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($document->category)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-pjs-blue/10 text-pjs-blue">
                                            {{ $document->category->{'name_' . app()->getLocale()} }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->file_size_formatted ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-pjs-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                            </svg>
                                            {{ $document->download_count }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('documents.download', $document) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-pjs-gold hover:bg-pjs-gold-dark text-white font-semibold rounded-md transition duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3 3m0 0l-3-3m3 3V8"/>
                                            </svg>
                                            {{ __('common.download') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden divide-y divide-gray-200">
                        @foreach($documents as $document)
                        <div class="p-6 hover:bg-gray-50 transition">
                            <div class="flex items-start mb-4">
                                <svg class="w-10 h-10 text-pjs-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-bold text-pjs-blue mb-1">
                                        {{ $document->{'title_' . app()->getLocale()} }}
                                    </h3>
                                    @if($document->category)
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-pjs-blue/10 text-pjs-blue mb-2">
                                        {{ $document->category->{'name_' . app()->getLocale()} }}
                                    </span>
                                    @endif
                                    @if($document->{'description_' . app()->getLocale()})
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ Str::limit($document->{'description_' . app()->getLocale()}, 150) }}
                                    </p>
                                    @endif
                                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                        <span>{{ $document->file_size_formatted ?? '-' }}</span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                            </svg>
                                            {{ $document->download_count }}
                                        </span>
                                    </div>
                                    <a href="{{ route('documents.download', $document) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-pjs-gold hover:bg-pjs-gold-dark text-white font-semibold rounded-md transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3 3m0 0l-3-3m3 3V8"/>
                                        </svg>
                                        {{ __('common.download') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($documents->hasPages())
                <div class="mt-8">
                    {{ $documents->links() }}
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        @if(app()->getLocale() === 'th')
                            ไม่พบเอกสาร
                        @else
                            No documents found
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
