<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImpersonateTenantHelpers;

class RedirectToAdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user) {
            if (ImpersonateTenantHelpers::getImpersonatedTenant($user)) {
                return redirect(\route('filament.pages.dashboard'));
            }

            if (config('public-web.routes.enabled') && \Illuminate\Support\Facades\Route::has('dashboard')) {
                return redirect(\route('dashboard'));
            }
        }

        return redirect(\route('filament.pages.dashboard'));
    }
}
