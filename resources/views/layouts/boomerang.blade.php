<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PJS Law and Accounting - Professional Legal and Accounting Consultants">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $site['name'] ?? 'PJS Law & Accounting')</title>

    <!-- ตั้งขนาดตัวอักษรทันที (กันจอกระพริบ) — default 100% ทุกจอ, เก็บเฉพาะเครื่อง (localStorage) -->
    <script>
        (function () {
            try {
                var s = parseFloat(localStorage.getItem('pjs-font-scale'));
                if (isNaN(s)) s = 1;
                s = Math.min(1.5, Math.max(0.86, s));
                document.documentElement.style.setProperty('--pjs-fs-scale', s);
                if (localStorage.getItem('pjs-theme') === 'dark') document.documentElement.classList.add('pjs-dark');
            } catch (e) {}
        })();
    </script>

    <!-- Favicons -->
    @if(!empty($site['favicon']))
        <link rel="icon" href="{{ $site['favicon'] }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @endif
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
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
	
	<link href="{{ asset('force-prompt-font.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
	
	<!-- GLightbox CSS (MIT — ฟรีเชิงพาณิชย์) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    
    <!-- Custom Styles -->
    <style>
        /* ฟอนต์ Prompt */
        * {
            font-family: 'Prompt', sans-serif !important;
        }

        /* ===== ปรับขนาดตัวอักษรทั้งเว็บ (rem-based scaling) ===== */
        :root { --pjs-fs-scale: 1; }
        html { font-size: calc(16px * var(--pjs-fs-scale)); }

        /* ===== เมนูปรับการแสดงผล (บนหัวเว็บ ข้างปุ่มเมนู) ===== */
        .pjs-ctrl { position: relative; z-index: 101; display: inline-flex; align-items: center; }
        .pjs-ctrl-btn {
            width: 38px; height: 38px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.15); color: #fff;
            cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px;
            transition: all .2s;
        }
        .pjs-ctrl-btn:hover { background: rgba(255,255,255,0.28); }
        .header.scrolled .pjs-ctrl-btn { border-color: #eadfb8; background: linear-gradient(135deg,#ffffff,#fbf5e4); color: #b8942f; }
        .pjs-ctrl-panel {
            position: absolute; right: 0; top: calc(100% + 14px); width: 236px;
            background: #fff; border: 1px solid #eee; border-radius: 16px;
            box-shadow: 0 14px 44px rgba(0,0,0,0.18); padding: 6px 12px;
            opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all .18s;
        }
        .pjs-ctrl.open .pjs-ctrl-panel { opacity: 1; visibility: visible; transform: none; }
        .pjs-ctrl-row { padding: 9px 0; border-bottom: 1px solid #f2f2f2; }
        .pjs-ctrl-row:last-child { border-bottom: none; }
        .pjs-ctrl-row .lbl { font-size: 11px; color: #9ca3af; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
        .pjs-seg { display: flex; gap: 4px; }
        .pjs-seg button {
            flex: 1; border: 1px solid #e5e7eb; background: #fff; color: #374151;
            border-radius: 9px; padding: 7px 2px; font-size: 13px; font-weight: 500; cursor: pointer;
            transition: all .15s; display: flex; align-items: center; justify-content: center; gap: 4px; line-height: 1;
        }
        .pjs-seg button:hover { border-color: #d4af37; color: #b8942f; }
        .pjs-seg button.on { background: #d4af37; border-color: #d4af37; color: #fff; }
        .pjs-seg .fsval { flex: 0 0 48px; font-weight: 600; color: #6b7280; background: #f9fafb; cursor: default; }
        .pjs-seg .fsval:hover { border-color: #e5e7eb; color: #6b7280; }

        /* ===== โหมดสีมืด (night) ===== */
        html.pjs-dark body { background: #0f172a; color: #cbd5e1; }
        html.pjs-dark .bg-gray,
        html.pjs-dark .footer,
        html.pjs-dark section.module:not(.parallax):not(.module-cover) { background: #0f172a !important; }
        html.pjs-dark .card,
        html.pjs-dark .widget-menu,
        html.pjs-dark .bg-white { background: #1e293b !important; }
        html.pjs-dark h1, html.pjs-dark h2, html.pjs-dark h3,
        html.pjs-dark h4, html.pjs-dark h5, html.pjs-dark h6 { color: #f1f5f9 !important; }
        html.pjs-dark p, html.pjs-dark li, html.pjs-dark .lead,
        html.pjs-dark td, html.pjs-dark label { color: #cbd5e1 !important; }
        html.pjs-dark .text-dark, html.pjs-dark .text-muted { color: #94a3b8 !important; }
        html.pjs-dark a:not(.btn) { color: #93c5fd; }
        html.pjs-dark .header.scrolled { background: #1e293b !important; }
        html.pjs-dark .header.scrolled .menu-item-span { color: #e2e8f0 !important; }

        /* ===== เนื้อหา rich text จาก editor (ให้แสดงเหมือนตอนแก้ไข) ===== */
        .rich-content { font-size: 1.05rem; line-height: 1.85; color: #3f4a53; word-wrap: break-word; }
        .rich-content > *:first-child { margin-top: 0; }
        .rich-content h1, .rich-content h2, .rich-content h3,
        .rich-content h4, .rich-content h5, .rich-content h6 { color: #1f2d3d; font-weight: 600; margin: 1.4em 0 .6em; line-height: 1.3; }
        .rich-content h1 { font-size: 1.9rem; } .rich-content h2 { font-size: 1.6rem; }
        .rich-content h3 { font-size: 1.35rem; } .rich-content h4 { font-size: 1.15rem; }
        .rich-content p { margin: 0 0 1.1em; }
        .rich-content a { color: #2563eb; text-decoration: underline; }
        .rich-content ul, .rich-content ol { margin: 0 0 1.1em; padding-left: 1.6em; }
        .rich-content ul { list-style: disc; } .rich-content ol { list-style: decimal; }
        .rich-content li { margin-bottom: .4em; }
        .rich-content img { max-width: 100%; height: auto; border-radius: 10px; margin: .4em 0; }
        .rich-content blockquote { border-left: 4px solid #c5a647; margin: 1.2em 0; padding: .4em 1.2em; color: #64748b; background: #faf8f0; border-radius: 0 8px 8px 0; }
        .rich-content table { width: 100%; border-collapse: collapse; margin: 1.2em 0; font-size: .95em; }
        .rich-content table td, .rich-content table th { border: 1px solid #e2e8f0; padding: 8px 12px; }
        .rich-content table th { background: #f8fafc; font-weight: 600; }
        .rich-content iframe { max-width: 100%; border-radius: 10px; margin: .6em 0; }
        .rich-content figure { margin: 1em 0; max-width: 100%; }
        .rich-content hr { border: none; border-top: 1px solid #e5e7eb; margin: 1.6em 0; }

        .rich-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; margin: 24px 0; }
        .rich-gallery a { display: block; overflow: hidden; border-radius: 10px; }
        .rich-gallery img { width: 100%; aspect-ratio: 1/1; object-fit: cover; transition: transform .3s; }
        .rich-gallery a:hover img { transform: scale(1.05); }

        .rich-files { margin: 20px 0; }
        .rich-files h6 { font-weight: 600; color: #334155; margin-bottom: 10px; }
        .rich-file { display: flex; align-items: center; gap: 10px; padding: 11px 14px; margin-bottom: 8px; border: 1px solid #e8eef7; border-radius: 10px; background: #fbfcfe; color: #334155; text-decoration: none; transition: all .2s; }
        .rich-file:hover { border-color: #2563eb; background: #f5f9ff; color: #2563eb; }
        .rich-file i { font-size: 20px; color: #2563eb; }
        .rich-file span { flex: 1; word-break: break-all; }
        .rich-file small { color: #94a3b8; flex-shrink: 0; }
        html.pjs-dark .rich-content { color: #cbd5e1; }
        html.pjs-dark .rich-content h1, html.pjs-dark .rich-content h2, html.pjs-dark .rich-content h3,
        html.pjs-dark .rich-content h4, html.pjs-dark .rich-content h5, html.pjs-dark .rich-content h6 { color: #f1f5f9; }

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
		.widget-icon.instagram {
			background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d62463 60%, #285AEB 100%);
			color: white;
		}
		.widget-icon.tiktok {
			background: #000; /* สีดำ */
			color: white;
			border: 2px solid #25F4EE; /* ขอบฟ้า TikTok */
		}

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
		
		.team-swiper {
  width: 100%;
}

.team-swiper .swiper-slide {
  height: auto; /* ให้การ์ดสูงตามเนื้อหา */
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
            
            .pjs-ctrl {
                order: 2;
                margin-left: auto;
                margin-right: 6px;
                z-index: 2000;
            }
            /* มือถือ: panel เป็น fixed หลุดจาก overflow ของ header (กันโดนตัด/บัง) */
            .pjs-ctrl-panel {
                position: fixed;
                top: 62px;
                right: 10px;
                left: auto;
                z-index: 2000;
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
                    <img src="{{ $site['logo'] ?? asset('frontend/images/PJS-Law-and-Accounting_Logo.png') }}" alt="{{ $site['name'] ?? 'PJS' }}">
                    <span>PJS</span>
                </a>
            </div>

            <div class="inner-navigation" id="mainNav">
                <div class="inner-nav">
                    <ul>
                        @foreach($publicMenu as $item)
                            @if(!empty($item['children']))
                                <li class="menu-item-has-children">
                                    <a href="{{ $item['url'] }}"><span class="menu-item-span">{{ $item['label'] }}</span></a>
                                    <ul class="sub-menu">
                                        @foreach($item['children'] as $child)
                                            <li><a href="{{ $child['url'] }}"><span class="menu-item-span">{{ $child['label'] }}</span></a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{ $item['url'] }}"><span class="menu-item-span">{{ $item['label'] }}</span></a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- เมนูปรับการแสดงผล (บนหัวเว็บ ข้างปุ่มเมนู) -->
            <div class="pjs-ctrl notranslate" id="pjsCtrl" translate="no">
                <button type="button" class="pjs-ctrl-btn" id="pjsCtrlBtn" aria-label="ตั้งค่าการแสดงผล" title="ตั้งค่าการแสดงผล"><i class="bi bi-sliders"></i></button>
                <div class="pjs-ctrl-panel">
                    <div class="pjs-ctrl-row">
                        <div class="lbl"><i class="bi bi-fonts"></i> ขนาดตัวอักษร</div>
                        <div class="pjs-seg">
                            <button type="button" onclick="pjsFontStep(-1)" aria-label="ลดขนาดตัวอักษร">A&minus;</button>
                            <button type="button" class="fsval" id="pjsFsLabel">100%</button>
                            <button type="button" onclick="pjsFontStep(1)" aria-label="เพิ่มขนาดตัวอักษร">A+</button>
                        </div>
                    </div>
                    <div class="pjs-ctrl-row">
                        <div class="lbl"><i class="bi bi-translate"></i> ภาษา</div>
                        <div class="pjs-seg">
                            <button type="button" onclick="changeLanguage('th')" id="lang-th" class="on">ไทย</button>
                            <button type="button" onclick="changeLanguage('en')" id="lang-en">EN</button>
                            <button type="button" onclick="changeLanguage('zh-CN')" id="lang-zh-CN">中文</button>
                        </div>
                    </div>
                    <div class="pjs-ctrl-row">
                        <div class="lbl"><i class="bi bi-circle-half"></i> โหมดสี</div>
                        <div class="pjs-seg">
                            <button type="button" onclick="pjsSetTheme('light')" id="pjsThemeLight" class="on"><i class="bi bi-sun"></i> สว่าง</button>
                            <button type="button" onclick="pjsSetTheme('dark')" id="pjsThemeDark"><i class="bi bi-moon-stars"></i> มืด</button>
                        </div>
                    </div>
                </div>
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
    <style>
        /* มือถือ: โลโก้ + เกี่ยวกับเรา + แผนผังเว็บไซต์ 3 คอลัมน์แถวเดียว — ย่อให้พอดี */
        @media (max-width: 767px) {
            .footer-1 { padding: 48px 0 28px 0 !important; }
            .footer-1 .footer-title { font-size: 12px; margin-bottom: 8px; }
            .footer-1 p, .footer-1 .footer-list a, .footer-1 .footer-list li { font-size: 10.5px; line-height: 1.5; }
            .footer-1 img { max-width: 100%; height: auto; }
            .footer-1 .footer-list { padding-left: 0; }
        }
    </style>
    <div class="container">
        <div class="row" style="margin-bottom: 40px;">
            <div class="col-4 col-lg-3 mb-4 text-center text-lg-start">
                <img src="{{ $site['logo'] ?? asset('frontend/images/PJS-Law-and-Accounting_Logo.png') }}" alt="{{ $site['name'] ?? 'PJS' }}">
            </div>
            <div class="col-4 col-lg-3 mb-4">
                <h6 class="footer-title">เกี่ยวกับเรา</h6>
                <p><strong>{{ $site['name'] ?? 'บริษัท PJS กฎหมายและการบัญชี จำกัด' }}</strong></p>
                <p>{{ $site['tagline'] ?: 'ที่ปรึกษากฎหมายและบัญชีมืออาชีพ พร้อมให้บริการธุรกิจของคุณด้วยความเชี่ยวชาญและประสบการณ์' }}</p>
            </div>

            <div class="col-4 col-lg-2 mb-4">
                <h6 class="footer-title">แผนผังเว็บไซต์</h6>
                <ul class="list-unstyled footer-list">
                    @foreach($publicMenu as $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="col-12 col-lg-4 mb-4">
                <h6 class="footer-title">ติดต่อเรา</h6>
                <ul class="list-unstyled footer-list mb-3">
                    @forelse($footerChannels as $ch)
                        <li>
                            <i class="{{ $ch->icon ?: 'bi bi-dot' }}"></i>
                            @if(in_array($ch->type, ['address']))
                                {{ $ch->value }}
                            @else
                                <a href="{{ $ch->href }}">{{ $ch->value }}</a>
                            @endif
                        </li>
                    @empty
                        <li><i class="bi bi-geo-alt"></i> 27/20 ซอย 4, แขวงบางบอน, เขตบางบอน, กรุงเทพมหานคร 10150</li>
                        <li><i class="bi bi-telephone"></i> <a href="tel:0922569828">092-256-9828</a></li>
                        <li><i class="bi bi-envelope"></i> <a href="mailto:pjs.legal2025@gmail.com">pjs.legal2025@gmail.com</a></li>
                    @endforelse
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
                    <p>&copy; {{ date('Y') }} {{ $site['name'] ?? 'PJS Law and Accounting Co., Ltd.' }} — สงวนลิขสิทธิ์</p>
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

            @forelse($widgetChannels as $ch)
                <a href="{{ $ch->href }}" @if($ch->is_social) target="_blank" @endif class="widget-item">
                    <div class="widget-icon {{ $ch->type }}">
                        <i class="{{ $ch->icon ?: 'bi bi-dot' }}"></i>
                    </div>
                    <div class="widget-text">{{ $ch->label ?: ($widgetText[$ch->type] ?? $ch->value) }}</div>
                </a>
            @empty
                <a href="tel:0922569828" class="widget-item">
                    <div class="widget-icon phone">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div class="widget-text">โทรหาเรา</div>
                </a>
            @endforelse
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
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	
	<!-- GLightbox JS (MIT — ฟรีเชิงพาณิชย์) -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', function () { if (window.GLightbox) { GLightbox({ selector: '.glightbox' }); } });</script>
    
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
				includedLanguages: 'th,en,zh-CN',
				autoDisplay: false
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
			['th', 'en', 'zh-CN'].forEach(function(code) {
				var el = document.getElementById('lang-' + code);
				if (el) el.classList.toggle('on', code === lang);
			});
		}

		window.addEventListener('load', function() {
			setTimeout(function() {
				var savedLang = localStorage.getItem('preferredLanguage');
				if (savedLang && savedLang !== 'th') {
					changeLanguage(savedLang);
				} else {
					updateLanguageUI('th');
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
    <!-- ตัวควบคุมขนาดตัวอักษร -->
    <script>
        (function () {
            var KEY = 'pjs-font-scale', MIN = 0.86, MAX = 1.5, STEP = 0.09;
            var isMobile = window.matchMedia('(max-width: 991px)').matches;
            function defaultScale() { return 1; } // เริ่มต้น 100% ทุกจอ (ปรับเองได้ เก็บเฉพาะเครื่อง)
            function clamp(v) { return Math.min(MAX, Math.max(MIN, v)); }
            function current() {
                var s = parseFloat(localStorage.getItem(KEY));
                return isNaN(s) ? defaultScale() : clamp(s);
            }
            function apply(s) {
                document.documentElement.style.setProperty('--pjs-fs-scale', s);
                var lbl = document.getElementById('pjsFsLabel');
                if (lbl) lbl.textContent = Math.round(s * 100) + '%';
            }
            window.pjsFontStep = function (dir) {
                var s = clamp(Math.round((current() + dir * STEP) * 100) / 100);
                localStorage.setItem(KEY, s);
                apply(s);
            };
            window.pjsFontReset = function () {
                localStorage.removeItem(KEY);
                apply(defaultScale());
            };
            apply(current());
        })();
    </script>

    <!-- เมนูปรับการแสดงผล: โหมดสี -->
    <script>
        (function () {
            var ctrl = document.getElementById('pjsCtrl');
            var btn = document.getElementById('pjsCtrlBtn');
            if (btn && ctrl) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    ctrl.classList.toggle('open');
                });
                document.addEventListener('click', function (e) {
                    if (!ctrl.contains(e.target)) ctrl.classList.remove('open');
                });
            }

            // โหมดสี (สว่าง/มืด)
            window.pjsSetTheme = function (mode) {
                document.documentElement.classList.toggle('pjs-dark', mode === 'dark');
                try { localStorage.setItem('pjs-theme', mode); } catch (e) {}
                var d = document.getElementById('pjsThemeDark'), l = document.getElementById('pjsThemeLight');
                if (d) d.classList.toggle('on', mode === 'dark');
                if (l) l.classList.toggle('on', mode !== 'dark');
            };
            pjsSetTheme(localStorage.getItem('pjs-theme') === 'dark' ? 'dark' : 'light');
        })();
    </script>
@stack('scripts')
</body>
</html>