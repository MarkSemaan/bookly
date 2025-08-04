<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use App\Events\OrderCreated;
use App\Events\OrderStatusChanged;
use App\Listeners\SendOrderCreatedNotification;
use App\Listeners\SendOrderStatusNotification;
use App\Listeners\UpdateBookStock;
use App\Listeners\PushOrderWebhook;
use App\Listeners\SendOrderSms;

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
        Schema::defaultStringLength(191); 

        Event::listen(OrderCreated::class, SendOrderCreatedNotification::class);
        Event::listen(OrderStatusChanged::class, SendOrderStatusNotification::class);
        Event::listen(OrderCreated::class, UpdateBookStock::class);
        Event::listen(OrderCreated::class, PushOrderWebhook::class);
        Event::listen(OrderStatusChanged::class, SendOrderSms::class);

    }
}
