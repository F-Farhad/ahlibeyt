<article class="bg-white flex flex-col my-4">
    <div class="shadow-none">
        <!-- Article Image -->
        <a href="{{route('post.show', $post)}}" class="hover:opacity-75">
            <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}" >
        </a>

        <div class="bg-white flex flex-col justify-start p-6">
                <a href="{{route('category.showAllPosts', $post->category)}}" class="text-blue-700 text-sm font-bold uppercase pb-4">
                    {{$post->category->title}}
                </a>
            <a href="{{route('post.show', $post)}}" class="text-3xl font-bold hover:text-gray-700">
                {{$post->title}}
            </a>
            <div class="text-sm pb-4">
                Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
            </div>
            <a href="{{route('post.show', $post)}}" class="pb-6">
                {!! $post->short_content !!}
            </a>
        </div>
    </div>
</article>