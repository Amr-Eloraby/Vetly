<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Booking;
use App\Models\Medicine;
use App\Observers\OrderObserver;
use App\Observers\BookingObserver;
use App\Observers\MedicineObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (request()->server('HTTP_CF_VISITOR')) {
            URL::forceScheme('https');
        }
        Order::observe(OrderObserver::class);
        Booking::observe(BookingObserver::class);
        Medicine::observe(MedicineObserver::class);
    }
}
