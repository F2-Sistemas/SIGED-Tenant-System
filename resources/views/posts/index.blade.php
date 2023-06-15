<x-theme title="Posts" resource="index">
    <x-slot name="topContent">
        <a
            class="mb-4 md:mb-0 w-full md:w-2/3 relative rounded inline-block opacity-95 hover:opacity-100"
            style="height: 24em;"
            href="#blog">
            <div class="absolute left-0 bottom-0 w-full h-full z-10"
                style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
            <img src="https://images.unsplash.com/photo-1493770348161-369560ae357d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2100&q=80"
                class="absolute left-0 top-0 w-full h-full rounded z-0 object-cover" />
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <span class="px-4 py-1 bg-black text-gray-200 inline-flex items-center justify-center mb-2">Nutrition</span>
                <h2 class="p-2 text-4xl bg-black font-semibold text-gray-100 leading-tight opacity-90">
                    Pellentesque a consectetur velit, ac molestie ipsum. Donec sodales, massa et auctor.
                </h2>
                <div class="flex mt-3">
                    <img src="https://randomuser.me/api/portraits/men/97.jpg"
                        class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-200 text-sm"> Mike Sullivan </p>
                        <p class="font-semibold text-gray-400 text-xs"> 14 Aug </p>
                    </div>
                </div>
            </div>
        </a>

        <a class="w-full md:w-1/3 relative rounded opacity-95 hover:opacity-100"
            style="height: 24em;"
            href="#blog"
        >
            <div class="absolute left-0 top-0 w-full h-full z-10"
                style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
            <img src="https://images.unsplash.com/photo-1543362906-acfc16c67564?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1301&q=80"
                class="absolute left-0 top-0 w-full h-full rounded z-0 object-cover" />
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <span class="px-4 py-1 bg-black text-gray-200 inline-flex items-center justify-center mb-2">Science</span>
                <h2 class="p-2 text-2xl bg-black font-semibold text-gray-100 leading-tight opacity-90">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </h2>
                <div class="flex mt-3">
                    <img
                        src="https://randomuser.me/api/portraits/women/97.jpg"
                        class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-200 text-sm"> Chrishell Staus </p>
                        <p class="font-semibold text-gray-400 text-xs"> 15 Aug </p>
                    </div>
                </div>
            </div>
        </a>
    </x-slot>

    <section class="mt-4 space-y-4">
        <h5 class="font-bold text-4xl uppercase text-gray-700 px-1 mb-2">Posts</h5>
        @foreach ($posts as $post)
        <x-themes.one.partials.post-list-item :post="$post" />
        @endforeach
        <div class="flex footer-pagination-container mb-5">
            {{ $posts->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </section>
</x-theme>
