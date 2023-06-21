<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ImpersonateController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'can:impersonate-a-tenant',
        ]);
    }

    /**
     * impersonate function
     *
     * @param Request $request
     * @param mixed $tenantId
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function impersonate(Request $request, $tenantId): Redirector|RedirectResponse
    {
        $this->middleware([
            'auth',
            'can:impersonate-a-tenant',
        ]);

        if (!$tenantId) {
            abort(404);
        }

        $tenant = Tenant::getByIdAndCache($tenantId);

        if (!$tenant) {
            abort(404);
        }

        \tenancy()->end();

        \session()->forget('impersonated_tenant');
        \session()->put('impersonated_tenant', $tenant?->id);
        tenancy()->initialize($tenant);

        $redirectTo = $request->get('redirect_to');

        if ($redirectTo || !filter_var($redirectTo, FILTER_VALIDATE_URL)) {
            return redirect(route('filament.pages.dashboard'));
        }

        return redirect($redirectTo);
    }

    /**
     * function end
     *
     * @param Type $type
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function end(Request $request): Redirector|RedirectResponse
    {
        $this->middleware([
            'auth',
            'can:impersonate-a-tenant',
        ]);

        \tenancy()->end();
        \session()->forget('impersonated_tenant');

        $redirectTo = $request->get('redirect_to');

        if ($redirectTo || !filter_var($redirectTo, FILTER_VALIDATE_URL)) {
            return redirect(route('filament.pages.dashboard'));
        }

        return redirect($redirectTo);
    }
}
