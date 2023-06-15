@if ($post->title ?? null)
    <article class="flex items-center justify-between opacity-90 hover:opacity-100">
        <div class="block rounded w-full lg:flex mb-5">
            <a href="{{ route('posts.show', $post) }}" class="no-underline">
            <div
                class="h-48 lg:w-48 flex-none bg-cover text-center overflow-hidden opacity-90"
                style="background-image: url('https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2100&q=80')"
                title="{{ $post->title ?? '' }}">
            </div>
            </a>

            <div class="bg-white rounded px-4 flex flex-col justify-between leading-normal pb-3">
                <div>
                    <a href="{{ route('posts.show', $post) }}" class="no-underline">
                        <div class="mt-3 md:mt-0 text-gray-700 font-bold text-2xl mb-2 hover:underline">
                            {{ $post->title ?? '' }}
                        </div>
                        <p class="text-gray-700 text-base hover:underline">
                            {!! \Str::limit(strip_tags($post->formatted_content), 260, '...') !!}
                        </p>
                    </a>
                </div>
                <div class="flex mt-3">
                    <img
                        src="https://randomuser.me/api/portraits/men/86.jpg"
                        class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-700 text-sm capitalize"> eduard franz </p>
                        <time datetime="{{ $post?->published_at?->toDateTimeString() }}" class="text-gray-600 text-xs">
                            {{ $post->published_at->format('j M, Y') }}
                        </time>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endif
