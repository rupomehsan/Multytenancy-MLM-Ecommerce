<?php

namespace App\Modules\MLM\Managements\Withdrow\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\MLM\Managements\Withdrow\Database\Models\WithdrawalRequest;
use App\Modules\MLM\Managements\Withdrow\Observers\WithdrawalRequestObserver;

/**
 * WithdrawalServiceProvider
 * 
 * Registers withdrawal-related services and observers.
 */
class WithdrawalServiceProvider extends ServiceProvider
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
     * @return void
     */
    public function boot()
    {
        // Register the withdrawal request observer
        WithdrawalRequest::observe(WithdrawalRequestObserver::class);
    }
}
