<article class="bg-white flex flex-col shadow my-4">

    <!-- Article Image -->
    <a href="{{route($routeName, $parametrs)}}" class="hover:opacity-75">
        <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}" class="aspect-[16/9] object-contain">
    </a>

    <div class="bg-white flex flex-col justify-start p-6">
            <a href="{{route('category.showAllPosts', $post->category)}}" class="text-primary text-sm font-bold uppercase pb-4">
                {{$post->category->title}}
            </a>
        <a href="{{route($routeName, $parametrs)}}" class="text-3xl font-bold hover:text-primary">
            {{$post->title}}
        </a>
        <div class="text-sm pb-4">
            Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
        </div>
        <a href="{{route($routeName, $parametrs)}}" class="pb-6">
            {!! $post->short_content !!}
        </a>
    </div>

</article>