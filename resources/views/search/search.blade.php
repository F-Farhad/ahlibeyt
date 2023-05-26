<x-app-layouts meta-title="Найденные посты" meta-description="Поиск по сайту">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col px-3">

        @foreach ($posts as $post)
            <div>
                <a href="{{route('post.show', $post)}}">
                    <h2 class="text-blue-500 font-bold text-lg sm:text-xl mb-2 ">
                        {!! str_replace(request()->get('q'), '<span class="bg-green-400 rounded">'.request()->get('q').'</span>', $post->title)!!}
                    </h2>
                </a>
                <div>
                    {!! str_replace(request()->get('q'), '<span class="bg-green-400 rounded">'.request()->get('q').'</span>', 
                        \App\Models\Post::getTextForMark(json_decode($post->content, true))) 
                    !!}
                    {{-- {!! str_replace(request()->get('q'), '<span class="bg-green-400 rounded">'.request()->get('q').'</span>', $post->short_content) !!} --}}
                </div>
            </div>
            <hr class="my-4">
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

    <x-side-bar />

</x-app-layouts>