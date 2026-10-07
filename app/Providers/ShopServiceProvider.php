<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Shop service provider - registers middleware aliases and view composers
 */

namespace App\Providers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('admin', \App\Http\Middleware\IsAdmin::class);
        $this->app['router']->aliasMiddleware('vendor', \App\Http\Middleware\IsVendor::class);

        View::composer(['layouts.shop', 'layouts.site', 'partials.site-header', 'partials.site-footer'], function ($view) {
            $view->with('shopSettings', [
                'name' => Setting::get('site_name', 'Mini Modem Case'),
                'tagline' => Setting::get('site_tagline', 'Protective enclosures for compact modems and routers'),
                'email' => Setting::get('contact_email', 'hello@minimodemcase.test'),
                'phone' => Setting::get('contact_phone', '+1 (555) 014-7788'),
                'address' => Setting::get('contact_address', '220 Circuit Avenue, Austin, TX 78701, United States'),
                'currency' => Setting::get('currency_symbol', '$'),
                'free_shipping_threshold' => (float) Setting::get('free_shipping_threshold', 75),
            ]);
        });

        View::composer(['partials.site-header'], function ($view) {
            $menu = Menu::where('location', 'header')->with('rootItems.children')->first();
            $view->with('headerMenu', $menu);
        });

        View::composer(['partials.site-footer'], function ($view) {
            $view->with('footerCategories', Category::where('is_active', true)->orderBy('sort_order')->take(6)->get());
        });
    }
}
