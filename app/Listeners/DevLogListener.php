<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class DevLogListener
{
    public array $passParams = [];

    /**
     * Create the event listener.
     */
    public function __construct(
        mixed ...$passParams
    ) {
        $this->passParams = $passParams;

        if (!static::persistLog()) {
            return;
        }

        Log::debug([
            'line' => __FILE__ . ':' . __LINE__,
            'passParams' => $this->passParams,
        ]);
    }

    /**
     * Handle the event.
     */
    public function handle(mixed $event): void
    {
        if (!static::persistLog()) {
            return;
        }

        Log::debug([
            'line' => __FILE__ . ':' . __LINE__,
            'passParams' => $this->passParams,
            'event' => $event,
        ]);
    }

    /**
     * function persistLog
     *
     * @return bool
     */
    public static function persistLog(): bool
    {
        return (bool) config('app-dev.log_listener.persist');
    }
}
