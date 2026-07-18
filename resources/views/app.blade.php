<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- PWA -->
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#c5a647">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="PJS">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="icon" href="/favicon.ico" sizes="any">

        <!-- Prompt font (ทั้งเว็บใช้ฟอนต์เดียวกัน) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap Icons (MIT, no attribution required) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <style>
            /* ===== Splash (โทนขาว-ทอง + โลโก้) 3 วินาที ก่อนเข้า admin ===== */
            #pjs-splash {
                position: fixed; inset: 0; z-index: 99999;
                background: #ffffff;
                display: flex; flex-direction: column; align-items: center; justify-content: center;
                gap: 20px;
                transition: opacity .5s ease, visibility .5s ease;
            }
            #pjs-splash.pjs-hide { opacity: 0; visibility: hidden; }
            #pjs-splash .pjs-logo {
                width: 108px; height: 108px; object-fit: contain;
                filter: drop-shadow(0 10px 26px rgba(197,166,71,.30));
                animation: pjsPop .8s cubic-bezier(.2,.8,.2,1) both;
            }
            #pjs-splash .pjs-brand {
                font-family: 'Prompt', sans-serif;
                font-size: 19px; font-weight: 700; letter-spacing: .3px; color: #b8942f;
                text-align: center; animation: pjsFade .9s ease .15s both;
            }
            #pjs-splash .pjs-brand small { display:block; font-size:11px; font-weight:400; letter-spacing:3px; color:#cbb779; margin-top:5px; }
            #pjs-splash .pjs-bar { width: 128px; height: 3px; border-radius: 3px; background: #f2ead2; overflow: hidden; }
            #pjs-splash .pjs-bar i { display:block; height:100%; width:38%; border-radius:3px; background: linear-gradient(90deg,#ecd89a,#c5a647); animation: pjsLoad 1.1s ease-in-out infinite; }
            @keyframes pjsPop { from{opacity:0; transform:scale(.82)} to{opacity:1; transform:scale(1)} }
            @keyframes pjsFade { from{opacity:0; transform:translateY(6px)} to{opacity:1; transform:none} }
            @keyframes pjsLoad { 0%{transform:translateX(-130%)} 100%{transform:translateX(330%)} }
            @media (prefers-reduced-motion: reduce){ #pjs-splash .pjs-logo,#pjs-splash .pjs-brand,#pjs-splash .pjs-bar i{animation:none} }

            /* ===== แบนเนอร์ เพิ่มลงหน้าจอหลัก ===== */
            .pjs-a2hs {
                position: fixed; left: 12px; right: 12px; bottom: 14px; z-index: 9998;
                max-width: 460px; margin: 0 auto;
                display: flex; align-items: center; gap: 12px;
                background: #fff; border: 1px solid #eadfb8; border-radius: 16px;
                box-shadow: 0 12px 40px rgba(0,0,0,.16); padding: 12px 14px;
                font-family: 'Prompt', sans-serif;
                animation: pjsFade .3s ease both;
            }
            .pjs-a2hs[hidden] { display: none; }
            .pjs-a2hs img { width: 42px; height: 42px; border-radius: 10px; flex: 0 0 auto; }
            .pjs-a2hs .txt { flex: 1 1 auto; min-width: 0; line-height: 1.35; }
            .pjs-a2hs .txt strong { display:block; font-size:14px; color:#1f2937; }
            .pjs-a2hs .txt span { display:block; font-size:12px; color:#6b7280; }
            .pjs-a2hs .pjs-install {
                flex: 0 0 auto; border:none; cursor:pointer;
                background: linear-gradient(135deg,#c5a647,#b8942f); color:#fff;
                font-size:13px; font-weight:600; padding:9px 14px; border-radius:10px;
            }
            .pjs-a2hs .pjs-install:hover { filter: brightness(1.05); }
            .pjs-a2hs .pjs-close {
                position:absolute; top:-9px; right:-9px; width:26px; height:26px;
                display:flex; align-items:center; justify-content:center;
                border:1px solid #e5e7eb; border-radius:50%; background:#fff; color:#6b7280;
                font-size:16px; line-height:1; cursor:pointer; box-shadow:0 3px 10px rgba(0,0,0,.15);
                transition: all .15s;
            }
            .pjs-a2hs .pjs-close:hover { background:#f3f4f6; color:#111827; }
        </style>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Splash -->
        <div id="pjs-splash" role="status" aria-label="กำลังเปิด PJS Law and Accounting">
            <img class="pjs-logo" src="/web-app-manifest-512x512.png" alt="PJS">
            <div class="pjs-brand">PJS Law and Accounting<small>LAW &amp; ACCOUNTING</small></div>
            <div class="pjs-bar"><i></i></div>
        </div>

        <!-- เพิ่มลงหน้าจอหลัก -->
        <div id="pjs-a2hs" class="pjs-a2hs" hidden>
            <img src="/web-app-manifest-192x192.png" alt="">
            <div class="txt">
                <strong>ติดตั้งแอป PJS</strong>
                <span id="pjs-a2hs-desc">เพิ่มลงหน้าจอหลักเพื่อเข้าใช้งานได้เร็วขึ้น</span>
            </div>
            <button id="pjs-a2hs-install" class="pjs-install" type="button">เพิ่มลงหน้าจอหลัก</button>
            <button id="pjs-a2hs-close" class="pjs-close" type="button" aria-label="ปิด">&times;</button>
        </div>

        @inertia

        <script>
            // ===== Splash: แสดง 3 วิ ต่อการเปิดแอป 1 ครั้ง =====
            (function () {
                var splash = document.getElementById('pjs-splash');
                if (!splash) return;
                if (sessionStorage.getItem('pjs-splash-shown')) { splash.remove(); return; }
                try { sessionStorage.setItem('pjs-splash-shown', '1'); } catch (e) {}
                setTimeout(function () {
                    splash.classList.add('pjs-hide');
                    setTimeout(function () { if (splash.parentNode) splash.remove(); }, 550);
                }, 3000);
            })();

            // ===== Service worker (เพื่อให้ติดตั้ง PWA ได้) =====
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/sw.js').catch(function () {});
                });
            }

            // ===== เพิ่มลงหน้าจอหลัก (แสดงทุกครั้งที่เข้าเว็บจนกว่าจะติดตั้ง) =====
            (function () {
                var deferred = null;
                var banner = document.getElementById('pjs-a2hs');
                var installBtn = document.getElementById('pjs-a2hs-install');
                var closeBtn = document.getElementById('pjs-a2hs-close');
                var desc = document.getElementById('pjs-a2hs-desc');

                function isInstalled() {
                    return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
                }
                function isIOS() {
                    return /iphone|ipad|ipod/i.test(navigator.userAgent) && !window.MSStream;
                }
                // แสดงทุกครั้งที่เข้าเว็บ หากยังไม่ได้ติดตั้ง (กดกากบาทแค่ปิดชั่วคราว รอบหน้าเข้ามาโชว์อีก)
                function canShow() { return !isInstalled(); }

                window.addEventListener('beforeinstallprompt', function (e) {
                    e.preventDefault();
                    deferred = e;
                    if (canShow() && banner) banner.hidden = false;
                });
                window.addEventListener('appinstalled', function () {
                    if (banner) banner.hidden = true;
                    deferred = null;
                });

                // iOS Safari ไม่มี beforeinstallprompt → แสดงคำแนะนำแทน
                if (isIOS() && !isInstalled() && banner) {
                    if (installBtn) installBtn.style.display = 'none';
                    if (desc) desc.textContent = 'แตะปุ่ม แชร์ แล้วเลือก “เพิ่มลงหน้าจอหลัก”';
                    banner.hidden = false;
                }

                if (installBtn) installBtn.addEventListener('click', function () {
                    if (deferred) { deferred.prompt(); deferred = null; }
                    if (banner) banner.hidden = true;
                });
                if (closeBtn) closeBtn.addEventListener('click', function () {
                    if (banner) banner.hidden = true; // ปิดเฉพาะรอบนี้ ไม่จำถาวร
                });
            })();
        </script>
    </body>
</html>
