{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<div class="filament-footer flex items-center justify-center">
    {{ \Filament\Facades\Filament::renderHook('footer.start') }}

    @if (config('filament.layout.footer.should_show_logo'))
        <div
            @class([
                'fixed bottom-0 left-0 w-full bg-gray-100 text-gray-900 p-1',
                'dark:text-gray-100 dark:bg-gray-900' => config('filament.dark_mode'),
            ])
        >
            <a
                href="https://tiagofranca.com?ref=f2sistemas&source={{ urlencode(config('app.name')) }}" target="_blank"
                rel="noopener noreferrer"
                class="text-gray-300 hover:text-primary-500 transition text-md w-full flex items-center justify-center">
                <span
                    class="text-sm fill-current text-gray-500 hover:text-primary-500 transition flex items-center justify-center">
                    F2 Sistemas
                    &copy;
                    {{ date('Y') }}
                </span>
            </a>
        </div>
    @endif

    {{ \Filament\Facades\Filament::renderHook('footer.end') }}
</div>

{{ \Filament\Facades\Filament::renderHook('footer.after') }}
