@props([
    'tenantId' => null,
])
<div>
    <strong>ID: {{ $this->tenantGet('id') }}</strong>
    <button
        type="button"
        wire:click="impersonate"
        @class([
            'text-gray-600 hover:text-primary-500 outline-none focus:underline',
            'dark:text-gray-300 dark:hover:text-primary-500' => config('filament.dark_mode'),
        ])
    >
        @lang('general.tenant.impersonate')
    </button>
</div>
