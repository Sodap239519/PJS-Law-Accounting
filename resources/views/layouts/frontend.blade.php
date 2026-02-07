<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? '' }} - {{ __('common.company_info.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-pjs-blue shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-pjs-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-xl">PJS</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="text-white font-bold text-lg leading-tight">
                                {{ __('common.company_info.name') }}
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex lg:items-center lg:space-x-1">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ __('common.home') }}
                    </a>
                    <a href="{{ route('vision') }}" class="nav-link {{ request()->routeIs('vision') ? 'active' : '' }}">
                        {{ __('common.vision') }}
                    </a>
                    <a href="{{ route('team.index') }}" class="nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}">
                        {{ __('common.team') }}
                    </a>
                    <a href="{{ route('news.index') }}" class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        {{ __('common.news') }}
                    </a>
                    <a href="{{ route('cases.index') }}" class="nav-link {{ request()->routeIs('cases.*') ? 'active' : '' }}">
                        {{ __('common.cases') }}
                    </a>
                    <a href="{{ route('documents.index') }}" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        {{ __('common.downloads') }}
                    </a>
                    <a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                        {{ __('common.contact') }}
                    </a>
                    
                    <!-- Language Switcher -->
                    <div class="ml-4 flex items-center space-x-2 border-l border-pjs-gold pl-4">
                        <a href="{{ route('locale.switch', 'th') }}" 
                           class="px-2 py-1 rounded {{ app()->getLocale() === 'th' ? 'bg-pjs-gold text-white' : 'text-gray-300 hover:text-white' }}">
                            TH
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="{{ route('locale.switch', 'en') }}" 
                           class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-pjs-gold text-white' : 'text-gray-300 hover:text-white' }}">
                            EN
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-300 hover:text-white focus:outline-none focus:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden lg:hidden bg-pjs-blue-dark">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    {{ __('common.home') }}
                </a>
                <a href="{{ route('vision') }}" class="mobile-nav-link {{ request()->routeIs('vision') ? 'active' : '' }}">
                    {{ __('common.vision') }}
                </a>
                <a href="{{ route('team.index') }}" class="mobile-nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}">
                    {{ __('common.team') }}
                </a>
                <a href="{{ route('news.index') }}" class="mobile-nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    {{ __('common.news') }}
                </a>
                <a href="{{ route('cases.index') }}" class="mobile-nav-link {{ request()->routeIs('cases.*') ? 'active' : '' }}">
                    {{ __('common.cases') }}
                </a>
                <a href="{{ route('documents.index') }}" class="mobile-nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                    {{ __('common.downloads') }}
                </a>
                <a href="{{ route('contact.index') }}" class="mobile-nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    {{ __('common.contact') }}
                </a>
                <div class="pt-4 border-t border-pjs-gold flex space-x-4 px-3">
                    <a href="{{ route('locale.switch', 'th') }}" 
                       class="flex-1 px-4 py-2 rounded text-center {{ app()->getLocale() === 'th' ? 'bg-pjs-gold text-white' : 'bg-gray-700 text-gray-300' }}">
                        ไทย
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}" 
                       class="flex-1 px-4 py-2 rounded text-center {{ app()->getLocale() === 'en' ? 'bg-pjs-gold text-white' : 'bg-gray-700 text-gray-300' }}">
                        English
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-pjs-blue text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-pjs-gold rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">PJS</span>
                        </div>
                        <h3 class="text-lg font-bold text-pjs-gold">{{ __('common.footer.about_us') }}</h3>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ __('common.company_info.name') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-pjs-gold">{{ __('common.footer.quick_links') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.home') }}</a></li>
                        <li><a href="{{ route('vision') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.vision') }}</a></li>
                        <li><a href="{{ route('team.index') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.team') }}</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.news') }}</a></li>
                        <li><a href="{{ route('cases.index') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.cases') }}</a></li>
                        <li><a href="{{ route('documents.index') }}" class="text-gray-300 hover:text-pjs-gold transition">{{ __('common.downloads') }}</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold mb-4 text-pjs-gold">{{ __('common.footer.contact_info') }}</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 mt-0.5 text-pjs-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm">{{ __('common.company_info.address') }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-pjs-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ __('common.company_info.phone') }}" class="text-sm hover:text-pjs-gold transition">{{ __('common.company_info.phone') }}</a>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-pjs-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ __('common.company_info.email') }}" class="text-sm hover:text-pjs-gold transition">{{ __('common.company_info.email') }}</a>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-pjs-gold flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.995 12c0-4.42-3.58-8-8-8s-8 3.58-8 8c0 3.99 2.94 7.29 6.78 7.89v-5.59h-2.04v-2.3h2.04V9.84c0-2.02 1.2-3.13 3.04-3.13.88 0 1.8.16 1.8.16v1.98h-1.01c-1 0-1.31.62-1.31 1.25v1.5h2.22l-.35 2.3h-1.87v5.59c3.84-.6 6.78-3.9 6.78-7.89z"/>
                            </svg>
                            <span class="text-sm">{{ __('common.company_info.line') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-pjs-gold mt-8 pt-8 text-center text-gray-400 text-sm">
                {{ __('common.footer.copyright') }}
            </div>
        </div>
    </footer>

    <style>
        .nav-link {
            @apply px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-pjs-blue-dark transition duration-150 ease-in-out;
        }
        .nav-link.active {
            @apply bg-pjs-gold text-white;
        }
        .mobile-nav-link {
            @apply block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-pjs-blue transition;
        }
        .mobile-nav-link.active {
            @apply bg-pjs-gold text-white;
        }
    </style>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>
