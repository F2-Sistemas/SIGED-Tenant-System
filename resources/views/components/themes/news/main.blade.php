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

    <title>Blog Homepage </title>
    {{-- https://codepen.io/steainsworth/pen/WNZYyxP --}}

    {{-- <link href="https://unpkg.com/tailwindcss@1.4.6/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css'>
    <style>
        .gradient {
            background-image: linear-gradient(to bottom,
                    rgba(243, 244, 246, 0.1),
                    rgba(0, 0, 0, 0.8));
        }

        .group:hover .group-hover\:translate-y-0 {
            transform: translateY(0);
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background-color: #fff;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }

        ::selection {
            background: rgb(107 114 128);
            /* WebKit/Blink Browsers */
        }

        ::-moz-selection {
            background: rgb(107 114 128);
            /* Gecko Browsers */
        }
    </style>
</head>

<body>

    <div class="bg-gray-200 min-h-screen">
        <header class="p-4 bg-white shadow-xl">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex justify-between items-center xl:mx-3">
                    <a href="#" class="font-semibold text-xl">Simple Blog Post Template UI</a>
                    <nav id="nav"
                        class="hidden bg-white md:block absolute top-0 left-0 right-0 bottom-0 p-4 z-40 flex items-center md:relative md:p-0">
                        <ul class="flex items-center flex-col md:flex-row w-full md:w-auto">
                            <li class="mx-3"><a href="#"
                                    class="border-b-2 border-white transition hover:border-gray-700 font-semibold hover:text-gray-500 py-1 text-2xl md:text-base block mb-1 md:mb-0">Home</a>
                            </li>
                            <li class="mx-3"><a href="#"
                                    class="border-b-2 border-white transition hover:border-gray-700 font-semibold hover:text-gray-500 py-1 text-2xl md:text-base block mb-1 md:mb-0">About</a>
                            </li>
                            <li class="mx-3"><a href="#"
                                    class="border-b-2 border-white transition hover:border-gray-700 font-semibold hover:text-gray-500 py-1 text-2xl md:text-base block mb-1 md:mb-0">Portfolio</a>
                            </li>
                            <li class="mx-3"><a href="#"
                                    class="border-b-2 border-gray-700 text-gray-400 transition hover:border-gray-700 font-semibold py-1 text-2xl md:text-base block pt-1 mb-1 md:mb-0">Blog</a>
                            </li>
                            <li class="ml-3"><button
                                    class="mt-4 md:mt-0 bg-gray-800 text-white px-6 md:px-3 py-2 md:py-1 font-bold transition duration-300 border-2 border-white hover:bg-gray-300 hover:text-black focus:border-black focus:bg-gray-400 text-2xl md:text-base">Contact</button>
                            </li>
                        </ul>
                        <a href="#" class="md:hidden" onclick="closeNav()"><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="times" class="absolute top-4 right-4 w-5" role="img" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 352 512">
                                <path fill="currentColor"
                                    d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                                </path>
                            </svg></a>
                    </nav>
                    <a href="#" class="md:hidden" onclick="openNav()"><svg aria-hidden="true" focusable="false" data-prefix="fas"
                            data-icon="bars" class="w-5" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z">
                            </path>
                        </svg></a>
                </div>
            </div>
        </header>
        <div class="max-w-screen-xl mx-auto px-4 pt-8 pb-4">
            <h2 class="border-b-2 border-yellow-600 mb-4"><span
                    class="bg-yellow-600 px-2 py-1 text-white uppercase tracking-wide">Trending</span></h2>
            <div class="flex flex-col flex-wrap md:flex-row md:-mx-2">
                <div class="w-full md:w-1/2 lg:w-1/4 mb-4 lg:mb-0">
                    <a href="#" class="h-72 md:h-96 block group relative md:mx-2 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1633265486064-086b219458ec?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&h=384&q=80"
                            class="absolute z-0 object-cover w-full h-72 md:h-96 transform group-hover:scale-150">
                        <div
                            class="absolute gradient transition duration-300 group-hover:bg-black group-hover:opacity-90 w-full h-72 md:h-96 z-10">
                        </div>
                        <div
                            class="absolute left-0 right-0 bottom-0 p-6 z-30 transform translate-y-1/2 transition duration-300 h-full group-hover:translate-y-0 delay-100">
                            <div class="h-1/2 relative">
                                <div class="absolute bottom-0">
                                    <h2
                                        class="font-bold text-white leading-tight transition duration-300 text-xl pb-6 group-hover:underline">
                                        Facebook and Instagram encryption plans delayed by Meta until 2023</h2>
                                </div>
                            </div>
                            <div class="h-1/2">
                                <p class="text-white pb-4 opacity-0 transition duration-300 group-hover:opacity-100">Plans to roll out
                                    end-to-end encryption on Facebook and Instagram have been delayed amid a row over child safety.</p>
                                <button
                                    class="bg-white text-black text-sm px-3 py-1 font-semibold opacity-0 transition duration-300 group-hover:opacity-100 border-2 border-white focus:border-black focus:bg-gray-300">Read
                                    More</button>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="h-72 md:h-96 w-full md:w-1/2 lg:w-1/4 mb-4 lg:mb-0">
                    <a href="#" class="h-72 md:h-96 block group relative md:mx-2 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1516245834210-c4c142787335?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&h=384&q=80"
                            class="absolute z-0 object-cover w-full h-72 md:h-96">
                        <div
                            class="absolute gradient transition duration-300 group-hover:bg-black group-hover:opacity-90 w-full h-72 md:h-96 z-100">
                        </div>
                        <div
                            class="absolute left-0 right-0 bottom-0 p-6 z-30 transform translate-y-1/2 transition duration-300 h-full group-hover:translate-y-0 delay-100">
                            <div class="h-1/2 relative">
                                <div class="absolute bottom-0">
                                    <h2
                                        class="font-bold text-white leading-tight transition duration-300 text-xl pb-6 group-hover:underline">
                                        El Salvador Bitcoin city planned at base of Conchagua volcano</h2>
                                </div>
                            </div>
                            <div class="h-1/2">
                                <p class="text-white pb-4 opacity-0 transition duration-300 group-hover:opacity-100">El Salvador plans to
                                    build a Bitcoin city at the base of a volcano, with the cryptocurrency used to fund the project.</p>
                                <button
                                    class="bg-white text-black text-sm px-3 py-1 font-semibold opacity-0 transition duration-300 group-hover:opacity-100 border-2 border-white focus:border-black focus:bg-gray-300">Read
                                    More</button>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="h-72 md:h-96 w-full md:w-1/2 lg:w-1/4 mb-4 md:mb-0">
                    <a href="#" class="h-72 md:h-96 block group relative md:mx-2 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1593941707882-a5bba14938c7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&h=384&q=80"
                            class="absolute z-0 object-cover w-full h-72 md:h-96">
                        <div
                            class="absolute gradient transition duration-300 group-hover:bg-black group-hover:opacity-90 w-full h-72 md:h-96 z-10">
                        </div>
                        <div
                            class="absolute left-0 right-0 bottom-0 p-6 z-30 transform translate-y-1/2 transition duration-300 h-full group-hover:translate-y-0 delay-100">
                            <div class="h-1/2 relative">
                                <div class="absolute bottom-0">
                                    <h2
                                        class="font-bold text-white leading-tight transition duration-300 text-xl pb-6 group-hover:underline">
                                        New homes in England to have electric car chargers by law</h2>
                                </div>
                            </div>
                            <div class="h-1/2">
                                <p class="text-white pb-4 opacity-0 transition duration-300 group-hover:opacity-100">New homes and
                                    buildings in England will be required by law to install electric vehicle charging points from next year.
                                </p>
                                <button
                                    class="bg-white text-black text-sm px-3 py-1 font-semibold opacity-0 transition duration-300 group-hover:opacity-100 border-2 border-white focus:border-black focus:bg-gray-300">Read
                                    More</button>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="h-72 md:h-96 w-full md:w-1/2 lg:w-1/4 mb-4 md:mb-0">
                    <a href="#" class="h-72 md:h-96 block group relative md:mx-2 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521542464131-cb30f7398bc6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&h=384&q=80"
                            class="absolute z-0 object-cover w-full h-72 md:h-96">
                        <div
                            class="absolute gradient transition duration-300 group-hover:bg-black group-hover:opacity-90 w-full h-72 md:h-96 z-10">
                        </div>
                        <div
                            class="absolute left-0 right-0 bottom-0 p-6 z-30 transform translate-y-1/2 transition duration-300 h-full group-hover:translate-y-0 delay-100">
                            <div class="h-1/2 relative">
                                <div class="absolute bottom-0">
                                    <h2
                                        class="font-bold text-white leading-tight transition duration-300 text-xl pb-6 group-hover:underline">
                                        Six million Sky routers had serious security flaw</h2>
                                </div>
                            </div>
                            <div class="h-1/2">
                                <p class="text-white pb-4 opacity-0 transition duration-300 group-hover:opacity-100">About six million Sky
                                    routers had a significant software bug that could have allowed hackers to take over home networks.</p>
                                <button
                                    class="bg-white text-black text-sm px-3 py-1 font-semibold opacity-0 transition duration-300 group-hover:opacity-100 border-2 border-white focus:border-black focus:bg-gray-300">Read
                                    More</button>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex flex-col flex-wrap md:flex-row md:-mx-4 my-8">
                <div class="w-full md:w-2/3 mb-4 lg:mb-0">
                    <div class="md:mx-4">
                        <h2 class="border-b-2 border-red-600 mb-4"><span
                                class="bg-red-600 px-2 py-1 text-white uppercase tracking-wide">Latest</span></h2>
                        <div class="flex flex-wrap items-center md:-mx-2">
                            <div class="w-full md:w-3/12">
                                <div class="md:mx-2">
                                    <img src="https://images.unsplash.com/photo-1485712207830-8a665e701494?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=732&h=488&q=80"
                                        class="w-full mb-4 md:mb-0">
                                </div>
                            </div>
                            <div class="md:w-9/12">
                                <div class="md:mx-2">
                                    <h2 class="text-gray-900 font-bold text-2xl pb-4 leading-tight"><a href="#"
                                            class="text-gray-900 hover:underline">People devote third of waking time to mobile apps</a>
                                    </h2>
                                    <p class="text-gray-800 pb-2">People are spending an average of 4.8 hours a day on their mobile phones,
                                        according to app monitoring firm App Annie.</p>
                                    <div class="text-gray-700 inline-block py-1 italic text-sm">Posted on: <time
                                            datetime="2021-11-19 20:00">November 19, 2021</time> by <a href="#"
                                            class="underline hover:no-underline">Stephen Ainsworth</a></div>
                                </div>
                            </div>
                            <div class="w-full mb-5 pb-5 border-b border-gray-400 md:mx-2"></div>
                        </div>
                        <div class="flex flex-wrap items-center md:-mx-2">
                            <div class="w-full md:w-3/12">
                                <div class="md:mx-2">
                                    <img src="https://images.unsplash.com/photo-1636188540036-1879f679c2b0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=732&h=488&q=80"
                                        class="w-full mb-4 md:mb-0">
                                </div>
                            </div>
                            <div class="md:w-9/12">
                                <div class="md:mx-2">
                                    <h2 class="text-gray-900 font-bold text-2xl pb-4 leading-tight"><a href="#"
                                            class="text-gray-900 hover:underline">Fact-checkers label YouTube a 'major conduit of online
                                            disinformation'</a></h2>
                                    <p class="text-gray-800 pb-2">Fact-checking organisations around the world say that YouTube is not
                                        doing enough to prevent the spread of misinformation on the platform.</p>
                                    <div class="text-gray-700 inline-block py-1 italic text-sm">Posted on: <time
                                            datetime="2021-11-19 20:00">November 19, 2021</time> by <a href="#"
                                            class="underline hover:no-underline">Stephen Ainsworth</a></div>
                                </div>
                            </div>
                            <div class="w-full mb-5 pb-5 border-b border-gray-400 md:mx-2"></div>
                        </div>
                        <div class="flex flex-wrap items-center md:-mx-2">
                            <div class="w-full md:w-3/12">
                                <div class="md:mx-2">
                                    <img src="https://images.unsplash.com/photo-1636114673156-052a83459fc1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=732&h=488&q=80"
                                        class="w-full mb-4 md:mb-0">
                                </div>
                            </div>
                            <div class="md:w-9/12">
                                <div class="md:mx-2">
                                    <h2 class="text-gray-900 font-bold text-2xl pb-4 leading-tight"><a href="#"
                                            class="text-gray-900 hover:underline">Meta monopoly case from FTC given go-ahead</a></h2>
                                    <p class="text-gray-800 pb-2">The US Federal Trade Commission (FTC) has been given the go-ahead to take
                                        Facebook to court over anti-trust rules.</p>
                                    <div class="text-gray-700 inline-block py-1 italic text-sm">Posted on: <time
                                            datetime="2021-11-19 20:00">November 19, 2021</time> by <a href="#"
                                            class="underline hover:no-underline">Stephen Ainsworth</a></div>
                                </div>
                            </div>
                            <div class="w-full mb-5 pb-5 border-b border-gray-400 md:mx-2"></div>
                        </div>
                        <div class="flex flex-wrap items-center md:-mx-2">
                            <div class="w-full md:w-3/12">
                                <div class="md:mx-2">
                                    <img src="https://images.unsplash.com/photo-1532356884227-66d7c0e9e4c2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=732&h=488&q=80"
                                        class="w-full mb-4 md:mb-0">
                                </div>
                            </div>
                            <div class="md:w-9/12">
                                <div class="md:mx-2">
                                    <h2 class="text-gray-900 font-bold text-2xl pb-4 leading-tight"><a href="#"
                                            class="text-gray-900 hover:underline">Virgin Mobile and O2 users will not face EU roaming
                                            charges</a></h2>
                                    <p class="text-gray-800 pb-2">Virgin Mobile and O2 phone users will not face roaming charges following
                                        announcements by other networks to reintroduce extra fees after Brexit.</p>
                                    <div class="text-gray-700 inline-block py-1 italic text-sm">Posted on: <time
                                            datetime="2021-11-19 20:00">November 19, 2021</time> by <a href="#"
                                            class="underline hover:no-underline">Stephen Ainsworth</a></div>
                                </div>
                            </div>
                            <div class="w-full mb-5 pb-5 border-b border-gray-400 md:mx-2"></div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 mb-4 lg:mb-0">
                    <div class="md:mx-4">
                        <h2 class="border-b-2 border-blue-600 mb-4"><span
                                class="bg-blue-600 px-2 py-1 text-white uppercase tracking-wide">Featured</span></h2>
                        <img src="https://images.unsplash.com/photo-1573804633927-bfcbcd909acd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=732&h=488&q=80"
                            class="w-full mb-4">
                        <h2 class="text-gray-900 font-bold text-2xl pb-4 leading-tight"><a href="#"
                                class="text-gray-900 hover:underline">France fines Google and Facebook over cookies</a></h2>
                        <p class="text-gray-800 pb-2">French regulators have hit Google and Facebook with fines totalling 210m euros
                            (£175m) over use of cookies.</p>
                        <div class="text-gray-700 inline-block py-1 italic text-sm">Posted on: <time datetime="2021-11-19 20:00">November
                                19, 2021</time> by <a href="#" class="underline hover:no-underline">Stephen Ainsworth</a></div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-4 bg-gray-900">
            <div class="text-center text-white text-lg">
                &copy; 2022 Created by <a class="underline hover:no-underline" href="https://stephenainsworth.com" target="_blank"
                    title="Stephen Ainsworth - Web Developer">Stephen Ainsworth</a>
            </div>
        </footer>
    </div>
    <script>
        function openNav() {
            document.getElementById("nav").classList.remove("hidden");
        }

        function closeNav() {
            document.getElementById("nav").classList.add("hidden");
        }
    </script>
</body>

</html>
