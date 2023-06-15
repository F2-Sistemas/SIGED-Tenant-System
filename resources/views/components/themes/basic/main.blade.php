@props(['title' => null])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>@isset($title) {{ $title }} &mdash; @endisset{{ config('app.name') }}</title>
</head>
<body class="flex flex-col min-h-screen antialiased bg-white font-sans">
    <nav class="w-full flex items-center justify-between max-w-3xl py-4 mx-auto">
        <span class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
            🚀
        </span>

        <ul class="flex items-center space-x-2 text-sm font-medium text-gray-700">
            <li class="hidden lg:block">
                <a class="px-3 py-2 rounded-lg" href="/">Home</a>
            </li>

            <li>
                <a class="px-3 py-2 rounded-lg" href="{{ route('posts.index') }}">Archive</a>
            </li>

            <li>
                <a class="inline-flex items-center px-3 py-2 rounded-lg text-gray-400" href="https://github.com/laravel-filament" target="_blank">
                    GitHub
                </a>
            </li>
        </ul>
    </nav>

    <main class="flex-1 w-full max-w-3xl mx-auto mt-24">
        {{ $slot }}
    </main>

    <footer class="border-t border-gray-300 mt-12 py-2">
        <div class="max-w-3xl mx-auto">
            <span class="font-medium text-xs text-gray-500">
                &copy; {{ date('Y') }} Your Name. All rights reserved.
            </span>
        </div>
    </footer>
</body>
</html>
