<?php

namespace App\Http\View\Composers;

use App\Services\SeoService;
use Illuminate\View\View;

/**
 * SEO View Composer - Automatically injects SeoService into all views
 * 
 * This composer makes the $seo variable available in all Blade templates,
 * allowing controllers to set SEO metadata and views to access it.
 * 
 * Registered in: App\Providers\AppServiceProvider
 */
class SeoComposer
{
    /**
     * Create a new SEO composer instance
     * 
     * @param SeoService $seo
     */
    public function __construct(protected SeoService $seo) {}

    /**
     * Bind data to the view
     * 
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        // Share the SeoService instance with the view
        $view->with('seo', $this->seo);
    }
}
