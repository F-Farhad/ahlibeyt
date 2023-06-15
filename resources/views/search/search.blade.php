<x-app-layouts meta-title="Найденные посты" meta-description="Поиск по сайту">

    <section class="container max-w-5xl mx-auto px-3">

        @foreach ($posts as $post)
            <div class="my-5">
                <a href="{{route('search.show', [$post, request()->get('search_expression'), ])}}">
                    <h2 class="text-primary font-bold text-2xl mb-2">
                    {!! \App\Models\Post::getMarkedText($post->title, request()->get('search_expression'))   !!}                    {{-- mark bg-hoverGreen don't touch notice--}}
                    </h2>
                </a>
                <div>
                    <a href="{{route('search.show', [$post, request()->get('search_expression'), ])}}">
                        {!! \App\Models\Post::getMarkedParagraph($post->short_content . $post->getContent(), request()->get('search_expression')) !!}
                    </a>
                </div>
            </div>
            <hr class="my-4 shadow">
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

</x-app-layouts>