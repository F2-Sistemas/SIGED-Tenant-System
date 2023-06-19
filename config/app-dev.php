<?php

return [
    /**
     * \App\Listeners\DevLogListener
     */
    'log_listener' => [
        'persist' => (bool) (
            env('APP_ENV', 'production') != 'production' ||
            env('PERSIST_LOG_LISTENER', false)
        ),
    ],
];
