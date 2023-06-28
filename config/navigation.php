<?php

return [
    /**
     * Resources que podem ser carregados sempre (todos os usuários e em todas as situações)
     * NOTA:
     * Pode ser que alguma navegação não seja carregada por alguma regra propria como exigir tenant, login etc.
     */
    'common_resources' => [
        // \App\Filament\Resources\SomeResource::class,
    ],

    'enabled_resources' => [
        // \AlexJustesen\FilamentSpatieLaravelActivitylog\Resources\ActivityResource::class,
        \App\Filament\Resources\CategoryResource::class,
        \App\Filament\Resources\DynamicContentResource::class,
        \App\Filament\Resources\PostResource::class,
        \App\Filament\Resources\UserResource::class,
        \App\Filament\Resources\OrcamentoResource::class,
    ],
];
