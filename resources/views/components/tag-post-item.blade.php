<article class="bg-white flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{route('tag.show.post', [$tag, $post])}}" class="hover:opacity-75">
        <img src="{{$post->getThumbnail()}}">
    </a>

    <div class="bg-white flex flex-col justify-start p-6">
            <a href="{{route('tag.show.post', [$tag, $post])}}" class="text-blue-700 text-sm font-bold uppercase pb-4">
                {{$post->category->title}}
            </a>
        <a href="{{route('post.show', $post)}}" class="text-3xl font-bold hover:text-gray-700">
            {{$post->title}}
        </a>
        <p class="text-sm pb-4">
            Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
        </p>
        <a href="{{route('tag.show.post', [$tag, $post])}}" class="pb-6">
            {!! $post->short_content !!}
        </a>
        {{-- <a href="{{route('post.show', $post)}}" class="uppercase text-gray-800 hover:text-black">Продолжить чтение<i class="fas fa-arrow-right"></i></a> --}}
    </div>
</article>