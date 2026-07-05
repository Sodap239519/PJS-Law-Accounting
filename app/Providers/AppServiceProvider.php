<?php

namespace App\Providers;

use App\Models\ContactChannel;
use App\Models\Setting;
use App\Support\SiteMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // ป้อนข้อมูลที่จัดการจากหลังบ้านให้ layout หน้าเว็บสาธารณะ (โลโก้/ชื่อเว็บ/เมนู/ช่องทางติดต่อ)
        View::composer('layouts.boomerang', function ($view) {
            $channels = ContactChannel::active()->orderBy('sort_order')->orderBy('id')->get();

            $view->with([
                'site' => [
                    'name' => Setting::get('site_name', 'PJS Law and Accounting'),
                    'tagline' => Setting::get('tagline'),
                    'logo' => Setting::get('logo'),
                    'favicon' => Setting::get('favicon'),
                ],
                'publicMenu' => SiteMenu::visible(),
                'contactChannels' => $channels,
                'footerChannels' => $channels->whereIn('type', ['address', 'phone', 'email', 'line']),
                'widgetChannels' => $channels->filter(fn ($c) => $c->is_social || $c->type === 'phone'),
                'widgetText' => [
                    'facebook' => 'พูดคุยผ่าน Facebook', 'instagram' => 'ติดตาม Instagram',
                    'tiktok' => 'ติดตาม TikTok', 'line' => 'Line Official',
                    'youtube' => 'ติดตาม YouTube', 'phone' => 'โทรหาเรา',
                ],
            ]);
        });
    }
}
