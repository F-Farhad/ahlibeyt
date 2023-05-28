<x-app-layouts meta-title="Найденные посты" meta-description="Поиск по сайту">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col px-3">

        @foreach ($posts as $post)
            <div>
                <a href="{{route('post.show', $post)}}">
                    <h2 class="text-blue-500 font-bold text-lg sm:text-xl mb-2 ">
                    {!! \App\Models\Post::getMarkedText($post->title, request()->get('q'))   !!}
                    </h2>
                </a>
                <div>
                    {!! \App\Models\Post::getMarkedParagraph($post->short_content . $post->getContent(), request()->get('q')) !!}
                </div>
            </div>
            <hr class="my-4">
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

    <x-side-bar />

</x-app-layouts>