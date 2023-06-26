<div
    class="filament-stats-card relative p-6 rounded-2xl shadow dark:bg-gray-800 forced-style bg-danger-500 filament-stats-overview-widget-card">
    <div class="space-y-2">
        <div class="grid items-center grid-cols-10 gap-1 text-white">
            <div class="col-span-1">
                <span class="h-10 w-10 text-red-500 font-bold">
                    @svg('heroicon-s-exclamation-circle', 'h-10 w-10 shrink-0')
                </span>
            </div>

            <div class="col-span-9">
                <span class="text-lg">
                    @lang('general.tenant.acting_as', [ 'tenant' => '', ])
                </span>
            </div>

            {{--  --}}
            <div class="col-span-1">
                @svg('heroicon-s-identification', 'h-10 w-10 shrink-0')
            </div>

            <div class="col-span-9 text-3xl">
                {{ $impersonatedTenant?->id }}

                <a
                    class="text-gray-100 hover:font-bold hover:text-primary-500 outline-none hover:outline focus:underline"
                    href="#tenant-info"
                >
                    <span class="inline text-sm">@lang('general.tenant.tenant_info')</span>
                </a>
            </div>

            <div class="col-span-10 w-full pt-3">
                <div class="grid items-center grid-cols-4 gap-1">
                    <div class="col-span-4">
                        <a
                            href="@route('end-impersonated-tenant')"
                            @class([
                                'text-xl',
                                'sm:text-md',
                                'font-bold',
                                'tracking-tight',
                                'bg-white',
                                'text-gray-600',
                                'rounded',
                                'px-2',
                                'hover:bg-primary-500',
                                'hover:text-white',
                            ])
                        >
                            @svg('heroicon-s-logout', 'h-5 w-5 shrink-0 inline')
                            @lang('general.tenant.remove_impersonated')
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
