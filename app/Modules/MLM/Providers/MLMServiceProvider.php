<?php

namespace App\Modules\MLM\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
use App\Modules\MLM\Observers\OrderObserverForMLM;

/**
 * MLM Service Provider
 * 
 * Registers MLM-related services, observers, and configurations.
 */
class MLMServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     * 
     * Registers observers for automatic MLM activity logging.
     *
     * @return void
     */
    public function boot()
    {
        // Register Order observer for MLM activity logging
        Order::observe(OrderObserverForMLM::class);
    }
}
