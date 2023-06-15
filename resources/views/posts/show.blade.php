<x-theme :title="$post->title" resource="post_show">
    <x-slot name="topContent">
        <a
            class="mb-4 md:mb-0 w-full md:w-3/3 relative rounded inline-block opacity-95 hover:opacity-100"
            style="height: 24em;"
            href="#blog">
            <div class="absolute left-0 bottom-0 w-full h-full z-10"
                style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
            <img src="https://images.unsplash.com/photo-1493770348161-369560ae357d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2100&q=80"
                class="absolute left-0 top-0 w-full h-full rounded z-0 object-cover" />
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <span class="px-4 py-1 bg-black text-gray-200 inline-flex items-center justify-center mb-2">Nutrition</span>
                <h2 class="p-2 text-4xl bg-black font-semibold text-gray-100 leading-tight opacity-90">
                    {{ $post->title ?? '' }}
                </h2>
                <div class="flex mt-3">
                    <img src="https://randomuser.me/api/portraits/men/86.jpg"
                        class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-200 text-sm capitalize"> Eduard Franz </p>
                        <time
                            datetime="{{ $post?->published_at?->toDateTimeString() }}"
                            class="font-semibold text-gray-400 text-xs">
                            {{ $post->published_at->format('j M, Y') }}
                        </time>
                    </div>
                </div>
            </div>
        </a>
    </x-slot>

    <section class="mt-4 space-y-4">
        <h5 class="font-bold text-4xl uppercase text-gray-700 px-1 mb-2">
            {{ $post->title }}
        </h5>

        <article class="flex items-center justify-between opacity-90 hover:opacity-100">
            <div class="block rounded w-full lg:flex mb-5">
                <a href="{{ route('posts.show', $post) }}" class="no-underline">
                </a>

                <div class="flex flex-col justify-between leading-normal pb-3">
                    <div class="bg-white rounded my-3 p-3">
                        <div class="mt-3 md:mt-0 text-gray-700 font-bold text-2xl mb-2">
                            {{ $post->title ?? '' }}
                        </div>

                        <div class="flex mt-3">
                            <a href="#author">
                                <img src="https://randomuser.me/api/portraits/men/86.jpg"
                                    class="h-10 w-10 rounded-full mr-2 object-cover" />
                            </a>

                            <div>
                                <p class="font-semibold text-gray-900 text-sm capitalize no-underline hover:underline">
                                    <a href="#author">Eduard Franz</a>
                                </p>
                                <time
                                    datetime="{{ $post?->published_at?->toDateTimeString() }}"
                                    class="font-semibold text-gray-400 text-xs">
                                    {{ $post->published_at->format('j M, Y') }}
                                </time>
                            </div>
                        </div>

                        <div class="text-gray-700 text-base my-5 text-justify p-3">
                            {!! $post->formatted_content !!}
                        </div>
                    </div>

                    <div class="my-3 py-3">
                        <!-- subscribe -->
                        <div class="bg-transparent mt-4 mb-4">
                            <h5 class="font-bold text-lg uppercase text-gray-700 mb-2"> Subscribe </h5>
                            <p class="text-gray-600">
                                Subscribe to our newsletter. We deliver the best health related articles to your inbox
                            </p>
                            <input placeholder="your email address"
                                class="text-gray-700 bg-gray-100 rounded-t hover:outline-none p-2 w-full mt-4 border my-1" />
                            <button class="py-2 bg-indigo-600 text-gray-200 rounded-b w-full capitalize tracking-wide">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</x-theme>
