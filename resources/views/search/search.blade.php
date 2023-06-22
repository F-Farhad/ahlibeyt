<x-app-layouts meta-title="Найденные посты" meta-description="Поиск по сайту">

    <section class="container max-w-5xl mx-auto px-3">

        @if($posts->count() == 0)
            <div class="my-5">
                <h2 class="text-black font-bold text-2xl mb-2 items-center">
                    По вашему запросу ничего не найдено
                </h2>
            </div>

        @else

            @foreach ($posts as $post)
                <div class="my-5">
                    <a href="{{route('search.show', [$post, request()->get('search_expression'), ])}}">
                        <h2 class="text-black hover:text-link font-bold text-2xl mb-2">             
                        {!! \App\Models\Post::getMarkedText($post->title, request()->get('search_expression'))   !!} {{-- mark bg-hoverGreen don't touch comment, else don't working marking words--}}
                        </h2>
                    </a>
                    <div>
                        <a class="hover:text-link" href="{{route('search.show', [$post, request()->get('search_expression'), ])}}">
                            {!! \App\Models\Post::getMarkedParagraph($post->short_content . $post->getContent(), request()->get('search_expression')) !!}
                        </a>
                    </div>
                </div>
                <hr class="my-4 shadow">
            @endforeach

            {{$posts->onEachSide(1)->links()}}

        @endif

    </section>

</x-app-layouts>