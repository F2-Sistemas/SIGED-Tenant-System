<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * Route name:
 * tenants.public.*
 * Ex: tenants.public.orcamentos.index
 */
Route::name('tenants.public.')->group(function () {
    Route::get('orcamentos/{anoVigencia?}/{tipoOrcamento?}', [
        \App\Http\Controllers\TenantPages\OrcamentosController::class, 'index'
    ])
        ->where('anoVigencia', '20[1-2][0-9]')
        ->name('orcamentos.index');
});
