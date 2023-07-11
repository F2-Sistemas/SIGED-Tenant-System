@php
    $sidebar = static::getResource()::sidebar($this->record);
@endphp

<div
    class="DIV1 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6"
>
    <div
        class="DIV1-1 col-span-12 rounded"
        :class="{
            'md:col-span-2': $store.pageWithSidebar.isOpen,
            'md:col-span-1': !$store.pageWithSidebar.isOpen,
            'lg:col-span-2': $store.pageWithSidebar.isOpen,
            'lg:col-span-1': !$store.pageWithSidebar.isOpen,
            'xl:col-span-2': $store.pageWithSidebar.isOpen,
            'xl:col-span-1': !$store.pageWithSidebar.isOpen,
            '2xl:col-span-2': $store.pageWithSidebar.isOpen,
            '2xl:col-span-1': !$store.pageWithSidebar.isOpen,
        }"
    >
        <div class="DIV1-1-1 w-full">
            <div class="grid grid-cols-2 gap-6 items-center rtl:space-x-reverse">
                <div class="col-span-2">
                    <button
                        type="button"
                        class="filament-sidebar-collapse-button shrink-0 hidden lg:flex items-center justify-center w-10 h-10 text-primary-500 rounded-full outline-none hover:bg-gray-500/5 focus:bg-primary-500/10"
                        x-bind:aria-label="$store.pageWithSidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
                        x-on:click.stop="$store.pageWithSidebar.isOpen ? $store.pageWithSidebar.close() : $store.pageWithSidebar.open()"
                        x-transition:enter="lg:transition delay-100"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                    >
                        <template x-if="$store.pageWithSidebar.isOpen">
                            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.25 7.5L16 12L20.25 16.5M3.75 12H12M3.75 17.25H16M3.75 6.75H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </template>

                        <template x-if="!$store.pageWithSidebar.isOpen">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </template>
                    </button>
                </div>

                @if ($sidebar->getTitle() != null || $sidebar->getDescription() != null)
                    <div class="col-span-2" x-show="$store.pageWithSidebar.isOpen">
                        @if ($sidebar->getTitle() != null)
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 truncate block">
                                {{ $sidebar->getTitle() }}
                            </h3>
                        @endif

                        @if ($sidebar->getDescription())
                            <p class="text-xs text-gray-500">
                                {{ $sidebar->getDescription() }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <ul
                class="@if ($sidebar->getTitle() != null || $sidebar->getDescription() != null) mt-4 @endif space-y-2 font-inter font-medium"
                wire:ignore
            >
                @foreach ($sidebar->getNavigationItems() as $item)
                    @if (!$item->isHidden())
                        <x-filament-page-with-sidebar::item
                            :active="$item->isActive()"
                            :icon="$item->getIcon()"
                            :active-icon="$item->getActiveIcon()"
                            :url="$item->getUrl()"
                            :badge="$item->getBadge()"
                            :badgeColor="$item->getBadgeColor()"
                            :shouldOpenUrlInNewTab="$item->shouldOpenUrlInNewTab()"
                        >
                        <span
                            class="truncate"
                            :class="{
                            'overflow-x-hidden': !$store.pageWithSidebar.isOpen
                        }">{{ $item->getLabel() }}</span>
                        </x-filament-page-with-sidebar::item>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div
        class="DIV1-2 col-span-12"
        :class="{
            'md:col-span-10': $store.pageWithSidebar.isOpen,
            'md:col-span-11': !$store.pageWithSidebar.isOpen,
            'lg:col-span-10': $store.pageWithSidebar.isOpen,
            'lg:col-span-11': !$store.pageWithSidebar.isOpen,
            'xl:col-span-10': $store.pageWithSidebar.isOpen,
            'xl:col-span-11': !$store.pageWithSidebar.isOpen,
            '2xl:col-span-10': $store.pageWithSidebar.isOpen,
            '2xl:col-span-11': !$store.pageWithSidebar.isOpen,
        }"
    >

    @if ($sidebar->getTitle() != null || $sidebar->getDescription() != null)
        <div class="col-span-12" x-show="!$store.pageWithSidebar.isOpen">
            @if ($sidebar->getTitle() != null)
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 truncate block">
                    {{ $sidebar->getTitle() }}
                </h3>
            @endif

            @if ($sidebar->getDescription())
                <p class="text-xs text-gray-500">
                    {{ $sidebar->getDescription() }}
                </p>
            @endif
        </div>
    @endif

        {{ $slot }}
    </div>
</div>
