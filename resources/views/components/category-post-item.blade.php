<article class="bg-white flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{route('category.showPost', [$category, $post])}}" class="hover:opacity-75">
        <img src="{{$post->getThumbnail()}}">
    </a>

    <div class="bg-white flex flex-col justify-start p-6">
        <a href="{{route('category.showPost', [$category, $post])}}" class="text-3xl font-bold hover:text-primary">
            {{$post->title}}
        </a>
        <div class="text-sm pb-4">
            Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
        </div>
        <a href="{{route('category.showPost', [$category, $post])}}" class="pb-6">
            {!! $post->short_content !!}
        </a>
    </div>

</article>