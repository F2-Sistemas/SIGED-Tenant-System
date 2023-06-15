<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0ed3cf">
    <meta name="msapplication-TileColor" content="#0ed3cf">
    <meta name="theme-color" content="#0ed3cf">

    <meta property="og:image" content="http://tailwindcomponents.com/storage/1451/temp79690.png?v=2023-05-30 15:08:39" />
    <meta property="og:image:width" content="1280" />
    <meta property="og:image:height" content="640" />
    <meta property="og:image:type" content="image/png" />

    <meta property="og:url" content="https://tailwindcomponents.com/component/blog-homepage/landing" />
    <meta property="og:title" content="Blog Homepage by justin22" />
    <meta property="og:description" content="A simple layout with feature" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@TwComponents" />
    <meta name="twitter:title" content="Blog Homepage by justin22" />
    <meta name="twitter:description" content="A simple layout with feature" />
    <meta name="twitter:image" content="http://tailwindcomponents.com/storage/1451/temp79690.png?v=2023-05-30 15:08:39" />

    <title>Blog Homepage by justin22. </title>

    {{-- <link href="https://unpkg.com/tailwindcss@1.4.6/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .footer-pagination-container nav[role="navigation"]>div+div {
            gap: .25rem;
        }
    </style>
</head>

<body class="bg-gray-200">
    <div class="hidden fixed bottom-0 left-0 right-0 z-40 px-4 py-3 text-center text-white bg-gray-800">
        This a Blog Homepage by justin22.
        <a class="text-gray-200 underline" href="https://tailwindcomponents.com/component/blog-homepage">Component details</a>
    </div>

    <div class="max-w-screen-xl mx-auto">
        <x-themes.one.partials.header />

        <main class="mt-10">
            @isset($topContent)
                <div class="block md:flex md:space-x-2 px-2 lg:p-0" {{ $attributes ?? '' }}>
                    {{ $topContent }}
                </div>
            @endisset

            <div class="block lg:flex lg:space-x-2 px-2 lg:p-0 mt-10 mb-10">
                <!-- post cards -->
                <div class="w-full lg:w-2/3">
                    {{ $slot }}
                </div>

                <x-themes.one.partials.right-sidebar />
            </div>
        </main>
        <!-- main ends here -->

        <!-- footer -->
        <footer class="border-t mt-32 pt-12 pb-32 px-4 lg:px-0">
            <div class="container mx-auto px-5 py-2">
                <div class="grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-4">
                    <div>
                        <h6 class="font-semibold text-gray-700 mb-4">Company</h6>
                        <ul>
                            <li> <a href="" class="block text-gray-600 py-2">Team</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">About us</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Press</a> </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-semibold text-gray-700 mb-4">Content</h6>
                        <ul>
                            <li> <a href="" class="block text-gray-600 py-2">Blog</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Privacy Policy</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Terms & Conditions</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Documentation</a> </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-semibold text-gray-700 mb-4">Content</h6>
                        <ul>
                            <li> <a href="" class="block text-gray-600 py-2">Blog</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Privacy Policy</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Terms & Conditions</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Documentation</a> </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-semibold text-gray-700 mb-4">Content</h6>
                        <ul>
                            <li> <a href="" class="block text-gray-600 py-2">Blog</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Privacy Policy</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Terms & Conditions</a> </li>
                            <li> <a href="" class="block text-gray-600 py-2">Documentation</a> </li>
                        </ul>
                    </div>
                </div>

                <div class="grid grid-cols-2 mt-10">
                    <div>
                        <p class="text-gray-800 text-xs text-center my-2 p-1 pb-0">
                            Design by community
                        </p>
                        <p class="text-gray-800 text-xs text-center my-2 p-1 pt-0">
                            Engine by <a class="text-purple-700" href="https://tiagofranca.com" target="_blank">Tiago França</a>
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-800 text-xs text-center my-2">
                            Company Xyz {{ date('Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-800 text-xs text-center my-2">
                            &copy; All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
