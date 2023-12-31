<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        /**
         * @see https://inertiajs.com/shared-data#sharing-data
         */
        return array_merge(parent::share($request), [
            // Synchronously...
            'appName' => config('app.name'),
            'laravelRequest' => [
                'query' => $request->query(),
            ],

            'auth' => [
                'user' => array_merge(($user ? $user?->toArray() : []), [
                    'permissions' => $user ? $user->getAllPermissionNames() : [],
                ]),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
