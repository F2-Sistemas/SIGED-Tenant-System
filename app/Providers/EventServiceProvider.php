<?php

namespace App\Providers;

use App\Listeners\ClearCacheOfDomainListOnDomainUpdate;
use App\Listeners\DevLogListener;
use Filament\Events\ServingFilament;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // \Stancl\Tenancy\Events\DomainUpdated::class => [
        \Stancl\Tenancy\Events\UpdatingDomain::class => [
            ClearCacheOfDomainListOnDomainUpdate::class,
        ],
        // EventClass::class => [
        //     DevLogListener::class,
        // ],

        ServingFilament::class => [
            DevLogListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
