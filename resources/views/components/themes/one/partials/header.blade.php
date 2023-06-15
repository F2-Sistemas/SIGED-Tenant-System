<!-- header -->
<header class="flex items-center justify-between py-2 border-b">
    <a href="#" class="px-2 lg:px-0 uppercase font-bold text-purple-800">
        LOGO
    </a>
    <ul class="inline-flex items-center">
        <li class="px-2 md:px-4">
            <a href="{{ route('home') }}" class="text-purple-600 font-semibold hover:text-purple-500">
                Home
            </a>
        </li>
        <li class="px-2 md:px-4">
            <a href="#about" class="text-gray-500 font-semibold hover:text-purple-500">
                About
            </a>
        </li>
        <li class="px-2 md:px-4">
            <a href="{{ route('posts.index') }}" class="text-gray-500 font-semibold hover:text-purple-500">
                Blog
            </a>
        </li>
        <li class="px-2 md:px-4">
            <a href="#contact" class="text-gray-500 font-semibold hover:text-purple-500">
                Contact
            </a>
        </li>
        @auth
        <li class="px-2 md:px-4 hidden md:block">
            <a href="{{ route('filament.pages.dashboard') }}" class="text-gray-500 font-semibold hover:text-purple-500">
                Dashboard
            </a>
        </li>
        <li class="px-2 md:px-4 hidden md:block">
            <form action="{{ route('filament.auth.logout') }}" method="post">
                @method('post')
                @csrf
                <button type="submit" class="text-red-400 font-semibold hover:text-red-500">
                    Logout
                </button>

            </form>
        </li>
        @else
            <li class="px-2 md:px-4 hidden md:block">
                <a href="{{ route('filament.auth.login') }}" class="text-gray-500 font-semibold hover:text-purple-500">
                    Login
                </a>
            </li>
            @if (\Route::has('filament.auth.register'))
            <li class="px-2 md:px-4 hidden md:block">
                <a href="{{ route('filament.auth.register') }}" class="text-gray-500 font-semibold hover:text-purple-500">
                    Register
                </a>
            </li>
            @endif
        @endauth
    </ul>

</header>
<!-- header ends here -->
