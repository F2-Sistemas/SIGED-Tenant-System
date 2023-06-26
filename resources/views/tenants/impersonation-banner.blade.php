@if ($impersonatedTenant ?? null)
<x-filament::dropdown
    placement="bottom-end"
>
    <style>
        .filament-dropdown-list-item-label {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
    <x-slot name="trigger" @class([
        'ml-4' => __('filament::layout.direction') === 'ltr',
        'mr-4' => __('filament::layout.direction') === 'rtl',
    ])>
        <div @class([
            'flex',
            'items-center',
            'justify-center',
            'gap-3',
            'px-3',
            'py-2',
            'rounded-lg',
            'font-medium',
            'transition',
            'bg-danger-500',
            'text-white',
        ])>
            @svg('heroicon-s-identification', 'h-5 w-5 shrink-0')
            <div class="flex flex-1">
                <span
                    x-show="($store.windowWidth > 700)"
                >
                    @lang('general.tenant.acting_as', [ 'tenant' => $impersonatedTenant?->id, ])
                </span>
                <span x-show="$store?.screenInfo?.isMobile"></span>
            </div>

            <div
                @class([
                    'inline-flex',
                    'items-center',
                    'justify-center',
                    'ml-auto',
                    'rounded-xl',
                    'tracking-tight',
                    'whitespace-normal',
                    'text-white bg-white/20',
                    'animate-pulse',
                ])
            >
                <span class="h-5 w-5 text-red-500 font-bold">
                    @svg('heroicon-s-exclamation-circle', 'h-5 w-5 shrink-0')
                </span>
            </div>
        </div>
    </x-slot>
    <x-filament::dropdown.list class="">
        @foreach (config('filament-language-switch.locales') as $key => $locale)
            @if (!app()->isLocale($key))
                <x-filament::dropdown.list.item
                    :href="route('end-impersonated-tenant')"
                    tag="a"
                >
                    <span
                        @class([
                            'w-6',
                            'h-6',
                            'flex',
                            'items-center',
                            'justify-center',
                            'mr-4',
                            'flex-shrink-0',
                            'rtl:ml-4',
                            'font-semibold',
                            'p-1',
                            'text-xs',
                        ])
                    >
                        @svg('heroicon-s-logout', 'h-5 w-5 shrink-0 inline')
                    </span>
                    <span class="hover:bg-transparent">
                        @lang('general.tenant.remove_impersonated')
                    </span>
                </x-filament::dropdown.list.item>
            @endif
        @endforeach

    </x-filament::dropdown.list>
</x-filament::dropdown>
@endif
