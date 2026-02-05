<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Services\SeoService;
use App\Http\View\Composers\SeoComposer;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\ECOMMERCE\Managements\Orders\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register SEO Service as singleton
        $this->app->singleton(SeoService::class, function ($app) {
            return new SeoService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }

        Paginator::useBootstrap();

        // Register Order Observer for MLM Commission Distribution
        Order::observe(OrderObserver::class);

        // Share general site settings to all views with safe defaults to avoid
        // "property on null" errors in Blade templates.
        try {
            $generalInfo = DB::table('general_infos')
                ->select(
                    'meta_title',
                    'meta_og_title',
                    'meta_keywords',
                    'meta_description',
                    'meta_og_description',
                    'meta_og_image',
                    'logo_dark',
                    'logo',
                    'fav_icon',
                    'company_name',
                    'email',
                    'address',
                    'custom_css',
                    'header_script',
                    'footer_script',
                    'payment_banner',
                    'play_store_link',
                    'contact',
                    'footer_copyright_text',
                    'app_store_link',
                    'whatsapp',
                    'messenger',
                    'telegram',
                    'youtube',
                    'facebook',
                    'twitter',
                    'linkedin',
                    'instagram',
                    'primary_color',
                    'secondary_color',
                    'tertiary_color',
                    'title_color',
                    'paragraph_color',
                    'border_color',
                    'google_tag_manager_status',
                    'google_tag_manager_id',
                    'google_analytic_status',
                    'google_analytic_tracking_id',
                    'fb_pixel_status',
                    'fb_pixel_app_id',
                    'tawk_chat_status',
                    'tawk_chat_link',
                    'messenger_chat_status',
                    'fb_page_id',
                    'short_description',
                    'guest_checkout',
                    'admin_login_bg_image',
                    'admin_login_bg_color'
                )
                ->where('id', 1)
                ->first();


            // `generalInfo` is provided globally by AppServiceProvider via View::share('generalInfo', ...)
            $categories = DB::table('categories')
                ->select('name', 'id', 'slug', 'show_on_navbar')
                ->where('status', 1)
                ->orderBy('serial', 'asc')
                ->get();
            $custom_pages = DB::table('custom_pages')->where('status', 1)->orderBy('id', 'asc')->get();
        } catch (\Throwable $e) {
            $generalInfo = null;
        }

        if (! $generalInfo) {
            $generalInfo = (object) [
                'meta_title' => null,
                'meta_og_title' => null,
                'meta_keywords' => null,
                'meta_description' => null,
                'meta_og_description' => null,
                'meta_og_image' => null,
                'logo_dark' => null,
                'logo' => null,
                'fav_icon' => null,
                'company_name' => config('app.name'),
                'email' => '',
                'address' => '',
                'custom_css' => '',
                'header_script' => '',
                'footer_script' => '',
                'payment_banner' => null,
                'play_store_link' => null,
                'contact' => null,
                'footer_copyright_text' => null,
                'app_store_link' => null,
                'whatsapp' => null,
                'messenger' => null,
                'telegram' => null,
                'youtube' => null,
                'facebook' => null,
                'twitter' => null,
                'linkedin' => null,
                'instagram' => null,
                'primary_color' => '#007bff',
                'secondary_color' => '#6c757d',
                'tertiary_color' => '#ffffff',
                'title_color' => '#212529',
                'paragraph_color' => '#6c757d',
                'border_color' => '#dee2e6',
                'google_tag_manager_status' => 0,
                'google_tag_manager_id' => null,
                'google_analytic_status' => 0,
                'google_analytic_tracking_id' => null,
                'fb_pixel_status' => 0,
                'fb_pixel_app_id' => null,
                'tawk_chat_status' => 0,
                'tawk_chat_link' => null,
                'messenger_chat_status' => 0,
                'fb_page_id' => null,
                'short_description' => null,
                'guest_checkout' => 0,
                'admin_login_bg_image' => null,
                'admin_login_bg_color' => '#0b2a44',
            ];
        }




        // Ensure categories and custom_pages are always defined (safe defaults)
        if (! isset($categories) || ! $categories) {
            $categories = collect();
        }

        if (! isset($custom_pages) || ! $custom_pages) {
            $custom_pages = collect();
        }

        View::share('generalInfo', $generalInfo);
        View::share('categories', $categories);
        View::share('custom_pages', $custom_pages);

        // Register SEO View Composer for all views
        // This makes the $seo service available in every Blade template
        View::composer('*', SeoComposer::class);
    }
}
