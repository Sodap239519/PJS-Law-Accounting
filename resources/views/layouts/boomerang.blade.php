<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PJS Law and Accounting - Professional Legal and Accounting Consultants">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PJS Law & Accounting')</title>
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('frontend/images/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/images/apple-touch-icon-114x114.png') }}">
    
    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Poppins:400,500,600&family=Playfair+Display:400i&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Plugins CSS -->
    <link href="{{ asset('frontend/css/plugins.min.css') }}" rel="stylesheet">
    
    <!-- Template Core CSS -->
    <link href="{{ asset('frontend/css/template.css') }}" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        /* ฟอนต์ Prompt */
        * {
            font-family: 'Prompt', sans-serif !important;
        }

        /* Header Container */
        .header .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            min-height: 0;
            position: relative;
        }

        .inner-header {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            z-index: 100;
        }

        .inner-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            vertical-align: middle;
        }

        .inner-brand img {
            height: 40px;
            width: auto;
            display: inline-block;
            vertical-align: middle;
        }

        .inner-brand span {
            font-size: 20px;
            font-weight: 600;
            color: white;
            line-height: 1;
            display: inline-block;
            vertical-align: middle;
        }

        /* Navigation */
        .inner-navigation {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .inner-nav ul {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 30px;
        }

        .inner-nav ul li {
            position: relative;
        }

        .inner-nav ul li a {
            text-decoration: none;
            position: relative;
            display: inline-block;
        }

        .inner-nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #d4af37;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .inner-nav ul li a:hover::after,
        .inner-nav ul li.active a::after {
            transform: scaleX(1);
        }

        .menu-item-span {
            color: white;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s;
        }

        .menu-item-span:hover {
            color: #d4af37;
        }

        /* Language Switcher */
        .lang-switcher {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            z-index: 100;
            position: relative;
        }

        .lang-switcher a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            cursor: pointer;
        }

        .lang-switcher a:hover {
            color: #d4af37;
        }

        .lang-switcher a.active {
            color: #d4af37;
            font-weight: bold;
        }

        .lang-switcher span {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Scroll Style */
        .header.scrolled {
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header.scrolled .inner-brand span {
            color: #000;
        }

        .header.scrolled .menu-item-span {
            color: #000 !important;
        }

        .header.scrolled .lang-switcher a {
            color: #000;
        }

        .header.scrolled .lang-switcher a.active {
            color: #d4af37 !important;
        }

        .header.scrolled .lang-switcher span {
            color: rgba(0, 0, 0, 0.3);
        }

        .header.scrolled .nav-toggle span {
            background-color: #000 !important;
        }
        
        /* Mobile Toggle */
        .nav-toggle {
            display: none;
        }

        .nav-toggle a {
            display: flex;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .nav-toggle span {
            width: 25px;
            height: 3px;
            background-color: white;
            transition: 0.3s;
        }

        /* Widget */
        .widget-toggle {
            background: linear-gradient(135deg, #d4af37 0%, #f4e5a1 100%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            cursor: pointer;
            transition: all 0.3s;
        }

        .widget-toggle:hover {
            transform: scale(1.1);
        }

        .widget-toggle i {
            font-size: 24px;
        }

        .floating-widget {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 1000;
        }

        .widget-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 20px;
            min-width: 280px;
            display: none;
        }

        .widget-menu.active {
            display: block;
        }

        .widget-menu h6 {
            margin: 0 0 15px 0;
            color: #333;
            font-weight: 600;
        }

        .widget-item {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 10px;
            text-decoration: none;
            background: #f8f9fa;
        }

        .widget-item:hover {
            background: #e9ecef;
        }

        .widget-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 12px;
        }

        .widget-icon.chat { background: #00b8d4; }
        .widget-icon.facebook { background: #1877f2; }
        .widget-icon.phone { background: #00c853; }
        .widget-icon.line { background: #00c300; }

        .widget-text {
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }

        /* Map */
        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
        }

        .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            border-radius: 8px;
        }
        
        /* ===== Google Translate - ซ่อนหมด ===== */
.goog-te-banner-frame {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
}

.goog-te-banner-frame.skiptranslate {
    display: none !important;
    visibility: hidden !important;
}

body {
    top: 0 !important;
    position: static !important;
}

.skiptranslate {
    display: none !important;
}

iframe.skiptranslate {
    display: none !important;
    visibility: hidden !important;
}

body > .skiptranslate {
    display: none !important;
}

#goog-gt-tt {
    display: none !important;
}

.goog-tooltip {
    display: none !important;
}

.goog-tooltip:hover {
    display: none !important;
}

.goog-text-highlight {
    background-color: transparent !important;
    box-shadow: none !important;
}

#google_translate_element {
    position: absolute;
    left: -9999px;
    opacity: 0;
    pointer-events: none;
    display: none !important;
}

.goog-logo-link {
    display: none !important;
}

.goog-te-gadget {
    color: transparent !important;
    font-size: 0 !important;
    display: none !important;
}

.goog-te-gadget img {
    display: none !important;
}

.goog-te-balloon-frame {
    display: none !important;
}

/* บังคับ body ไม่มี padding/margin จาก Google */
body {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* ป้องกันไม่ให้ปุ่มเปลี่ยนภาษาถูกแปล */
.lang-switcher,
.lang-switcher *,
.lang-switcher a,
.lang-switcher span {
    translate: no !important;
}

.notranslate {
    translate: no !important;
}

/* Footer Spacing */
.footer {
    padding: 60px 0 10px 0;
}

.footer .container > .row:first-child {
    margin-bottom: 30px;
}

.footer hr {
    border-color: rgba(255, 255, 255, 0.1);
}

        
        /* Mobile Responsive */
        @media (max-width: 991px) {
            html, body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }
            
            .header {
                background-color: transparent !important;
            }
            
            .header.scrolled {
                background-color: #fff !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .header .container-fluid {
                padding: 15px 20px;
                overflow-x: hidden;
                max-width: 100%;
            }
            
            .inner-header {
                order: 1;
                z-index: 1002;
            }
            
            .inner-brand img {
                height: 35px;
            }
            
            .inner-brand span {
                font-size: 18px;
                color: white;
                transition: color 0.3s;
            }
            
            .header.scrolled .inner-brand span {
                color: #000;
            }
            
            .lang-switcher {
                order: 2;
                margin-left: auto;
                margin-right: 10px;
                z-index: 1002;
            }
            
            .lang-switcher a {
                color: white;
                transition: color 0.3s;
            }
            
            .lang-switcher a.active {
                color: #d4af37;
            }
            
            .lang-switcher span {
                color: rgba(255, 255, 255, 0.5);
                transition: color 0.3s;
            }
            
            .header.scrolled .lang-switcher a {
                color: #000;
            }
            
            .header.scrolled .lang-switcher a.active {
                color: #d4af37 !important;
            }
            
            .header.scrolled .lang-switcher span {
                color: rgba(0, 0, 0, 0.3);
            }
            
            .nav-toggle {
                display: flex !important;
                order: 3;
                z-index: 1002;
            }
            
            .nav-toggle a {
                padding: 5px;
            }
            
            .nav-toggle span {
                width: 25px;
                height: 3px;
                background-color: white;
                transition: background-color 0.3s;
            }
            
            .header.scrolled .nav-toggle span {
                background-color: #000 !important;
            }
            
            .inner-navigation {
                position: fixed !important;
                top: 70px !important;
                right: -100% !important;
                left: auto !important;
                width: 50% !important;
                max-width: 400px !important;
                min-width: 280px !important;
                height: auto !important;
                max-height: calc(100vh - 70px) !important;
                display: block !important;
                flex: none !important;
                justify-content: flex-start !important;
                align-items: flex-start !important;
                background: #fff !important;
                padding: 20px 0 20px 0 !important;
                box-shadow: -5px 0 30px rgba(0,0,0,0.3) !important;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
                z-index: 999 !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                transform: translateX(0) !important;
            }
            
            .inner-navigation.show {
                right: 0 !important;
            }
            
            .inner-navigation::after {
                display: none !important;
            }
            
            .inner-navigation::before {
                display: none !important;
            }
            
            .inner-nav {
                padding-top: 0 !important;
                width: 100%;
            }
            
            .inner-nav ul {
                flex-direction: column !important;
                gap: 0 !important;
                align-items: flex-start !important;
                padding: 0 !important;
                width: 100% !important;
                margin: 0 !important;
            }
            
            .inner-nav ul li {
                width: 100% !important;
                padding: 0 !important;
                border-bottom: 1px solid rgba(0,0,0,0.08) !important;
                opacity: 0;
                transform: translateX(50px);
                transition: all 0.3s ease;
            }
            
            .inner-nav ul li:last-child {
                border-bottom: none !important;
            }
            
            .inner-navigation.show .inner-nav ul li {
                opacity: 1;
                transform: translateX(0);
            }
            
            .inner-navigation.show .inner-nav ul li:nth-child(1) { transition-delay: 0.05s; }
            .inner-navigation.show .inner-nav ul li:nth-child(2) { transition-delay: 0.1s; }
            .inner-navigation.show .inner-nav ul li:nth-child(3) { transition-delay: 0.15s; }
            .inner-navigation.show .inner-nav ul li:nth-child(4) { transition-delay: 0.2s; }
            .inner-navigation.show .inner-nav ul li:nth-child(5) { transition-delay: 0.25s; }
            .inner-navigation.show .inner-nav ul li:nth-child(6) { transition-delay: 0.3s; }
            .inner-navigation.show .inner-nav ul li:nth-child(7) { transition-delay: 0.35s; }
            
            .inner-nav ul li a {
                display: block !important;
                padding: 18px 30px !important;
                position: relative;
            }
            
            .inner-nav ul li a::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 0;
                background: #d4af37;
                transition: height 0.3s;
            }
            
            .inner-nav ul li a:hover::before {
                height: 100%;
            }
            
            .inner-nav ul li a .menu-item-span {
                color: #333 !important;
                font-size: 16px !important;
                font-weight: 500 !important;
                letter-spacing: 0.3px;
                transition: all 0.3s;
            }
            
            .inner-nav ul li a:hover .menu-item-span {
                color: #d4af37 !important;
                padding-left: 10px;
            }
            
            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 998;
                backdrop-filter: blur(3px);
                pointer-events: none;
            }
            
            .mobile-overlay.show {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
        }

        @media (min-width: 992px) {
            .inner-navigation {
                display: flex !important;
                position: static;
            }
            
            .mobile-overlay {
                display: none !important;
            }
            
            .inner-nav::before {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Google Translate Element -->
    <div id="google_translate_element"></div>
    
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Preloader -->
    <div class="page-loader">
        <div class="page-loader-inner">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header header-transparent" id="mainHeader">
        <div class="container-fluid">
            <div class="inner-header">
                <a class="inner-brand notranslate" href="{{ route('home') }}">
                    <img src="{{ asset('frontend/images/PJS-Law-and-Accounting_Logo.png') }}" alt="PJS">
                    <span>PJS</span>
                </a>
            </div>
            
            <div class="inner-navigation" id="mainNav">
                <div class="inner-nav">
                    <ul>
                        <li><a href="{{ route('home') }}"><span class="menu-item-span">หน้าหลัก</span></a></li>
                        <li><a href="{{ route('about.index') }}"><span class="menu-item-span">เกี่ยวกับเรา</span></a></li>
                        <li><a href="{{ route('services.index') }}"><span class="menu-item-span">บริการ</span></a></li>
                        <li><a href="{{ route('team.index') }}"><span class="menu-item-span">ทีมงาน</span></a></li>
                        <!-- <li><a href="{{ route('news.index') }}"><span class="menu-item-span">ข่าวสาร</span></a></li> -->
                        <li><a href="{{ route('home') }}#latest-news"><span class="menu-item-span">ข่าวสาร</span></a></li>
                        <!-- <li><a href="{{ route('cases.index') }}"><span class="menu-item-span">คดีตัวอย่าง</span></a></li> -->
                        <li><a href="{{ route('home') }}#case-studies"><span class="menu-item-span">คดีตัวอย่าง</span></a></li>
                        <li><a href="{{ route('contact.index') }}"><span class="menu-item-span">ติดต่อเรา</span></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="lang-switcher notranslate" translate="no">
                <a href="javascript:void(0)" onclick="changeLanguage('th')" id="lang-th" class="active">TH</a>
                <span>|</span>
                <a href="javascript:void(0)" onclick="changeLanguage('en')" id="lang-en">EN</a>
            </div>
            
            <div class="nav-toggle">
                <a href="#" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
<footer class="footer footer-1 bg-dark" style="padding: 80px 0 40px 0;">
    <div class="container">
        <div class="row" style="margin-bottom: 40px;">
            <div class="col-lg-3 col-md-6 mb-4">
                <img src="{{ asset('frontend/images/PJS-Law-and-Accounting_Logo.png') }}" alt="PJS">
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">เกี่ยวกับเรา</h6>
                <p><strong>บริษัท PJS กฎหมายและการบัญชี จำกัด</strong></p>
                <p>ที่ปรึกษากฎหมายและบัญชีมืออาชีพ พร้อมให้บริการธุรกิจของคุณด้วยความเชี่ยวชาญและประสบการณ์</p>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="footer-title">แผนผังเว็บไซต์</h6>
                <ul class="list-unstyled footer-list">
                    <li><a href="{{ route('home') }}">หน้าหลัก</a></li>
                    <li><a href="{{ route('about.index') }}">เกี่ยวกับเรา</a></li>
                    <li><a href="{{ route('services.index') }}">บริการ</a></li>
                    <li><a href="{{ route('team.index') }}">ทีมงานของเรา</a></li>
                    <li><a href="{{ route('news.index') }}">ข่าวสาร</a></li>
                    <li><a href="{{ route('cases.index') }}">คดีตัวอย่าง</a></li>
                    <li><a href="{{ route('contact.index') }}">ติดต่อเรา</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <h6 class="footer-title">ติดต่อเรา</h6>
                <ul class="list-unstyled footer-list mb-3">
                    <li><i class="bi bi-geo-alt"></i> 27/20 ซอย 4, แขวงบางบอน, เขตบางบอน, กรุงเทพมหานคร 10150</li>
                    <li><i class="bi bi-telephone"></i> <a href="tel:0922569828">092-256-9828</a></li>
                    <li><i class="bi bi-envelope"></i> <a href="mailto:pjs.legal2025@gmail.com">pjs.legal2025@gmail.com</a></li>
                    <li><i class="bi bi-line"></i> @pjslegal</li>
                </ul>
                
                <div class="map-responsive">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.8!2d100.4!3d13.65!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDM5JzAwLjAiTiAxMDDCsDI0JzAwLjAiRQ!5e0!3m2!1sen!2sth!4v1234567890" 
                            width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        
        <hr style="margin: 30px 0 20px 0; border-color: rgba(255, 255, 255, 0.1);">

        <div class="row">
            <div class="col-md-12">
                <div class="footer-copyright text-center" style="padding: 10px 0;">
                    <p>&copy; 2025 PJS Law and Accounting Co., Ltd. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

    <!-- Floating Contact Widget -->
    <div class="floating-widget">
        <div class="widget-menu" id="widgetMenu">
            <h6>ติดต่อเรา</h6>
            
            <a href="{{ route('contact.index') }}" class="widget-item">
                <div class="widget-icon chat">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="widget-text">ติดต่อเราที่นี่เลยค่ะ</div>
            </a>
            
            {{-- <a href="https://m.me/YOUR_FB_PAGE" target="_blank" class="widget-item">
                <div class="widget-icon facebook">
                    <i class="bi bi-messenger"></i>
                </div>
                <div class="widget-text">พูดคุยผ่าน Facebook</div>
            </a> --}}
            
            <a href="tel:0922569828" class="widget-item">
                <div class="widget-icon phone">
                    <i class="bi bi-telephone"></i>
                </div>
                <div class="widget-text">โทรหาเรา</div>
            </a>
            
            {{-- <a href="https://line.me/ti/p/sLjBmLc4UW" target="_blank" class="widget-item">
                <div class="widget-icon line">
                    <i class="bi bi-line"></i>
                </div>
                <div class="widget-text">Line Official</div>
            </a> --}}
        </div>
        
        <div class="widget-toggle" id="widgetToggle">
            <i class="bi bi-chat-dots"></i>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/custom/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom/plugins.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom/custom.min.js') }}"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // ระยะเวลา animation (มิลลิวินาที)
            easing: 'ease-in-out', // ประเภท easing
            once: true, // animation เล่นครั้งเดียว
            offset: 100, // ระยะห่างจากขอบล่างก่อน trigger (px)
            delay: 0, // ดีเลย์ก่อน animation (มิลลิวินาที)
        });
    </script>
    
    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'th',
                includedLanguages: 'th,en'
            }, 'google_translate_element');
        }
        
        function changeLanguage(lang) {
            var selectField = document.querySelector("select.goog-te-combo");
            if (selectField) {
                selectField.value = lang;
                selectField.dispatchEvent(new Event('change'));
                updateLanguageUI(lang);
                localStorage.setItem('preferredLanguage', lang);
            } else {
                setTimeout(function() { changeLanguage(lang); }, 100);
            }
        }
        
        function updateLanguageUI(lang) {
            document.querySelectorAll('.lang-switcher a').forEach(function(el) {
                el.classList.remove('active');
            });
            document.getElementById('lang-' + lang).classList.add('active');
        }
        
        window.addEventListener('load', function() {
            setTimeout(function() {
                var savedLang = localStorage.getItem('preferredLanguage');
                if (savedLang && savedLang !== 'th') {
                    changeLanguage(savedLang);
                }
            }, 1000);
        });
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <script>
        // Header Scroll
        window.addEventListener('scroll', function() {
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Widget Toggle
        if (document.getElementById('widgetToggle')) {
            document.getElementById('widgetToggle').addEventListener('click', function() {
                document.getElementById('widgetMenu').classList.toggle('active');
            });
        }
        
        document.addEventListener('click', function(event) {
            const widget = document.querySelector('.floating-widget');
            if (widget && !widget.contains(event.target)) {
                var menu = document.getElementById('widgetMenu');
                if (menu) menu.classList.remove('active');
            }
        });
        
        // Mobile Menu
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mainNav = document.getElementById('mainNav');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        function openMenu() {
            if (mainNav && mobileOverlay) {
                mainNav.classList.add('show');
                mobileOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeMenu() {
            if (mainNav && mobileOverlay) {
                mainNav.classList.remove('show');
                mobileOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                openMenu();
            });
        }
        
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeMenu);
        }
        
        document.querySelectorAll('.inner-nav ul li a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    closeMenu();
                }
            });
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMenu();
            }
        });
    </script>
@stack('scripts')
</body>
</html>