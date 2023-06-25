<?php

return [
    'error_pages' => [
        'links' => [
            [
                'label' => 'Dashboard',
                'route' => 'filament.pages.dashboard',
            ],
            [
                'label' => 'Send a feed',
                'url' => null,
                'can' => 'send-a-feedback'
            ],
            // [
            //     'label' => 'Send a feed',
            //     'url' => null,
            //     'can' => 'send-a-feedback'
            // ],
        ],
    ],
];
