<article class="flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="#" class="hover:opacity-75">
        <img src="{{$post->getThumbnail()}}">
    </a>
{{-- @dd($post->category) --}}
    <div class="bg-white flex flex-col justify-start p-6">
            <a href="{{route('category.show', $post->category)}}" class="text-blue-700 text-sm font-bold uppercase pb-4">
                {{$post->category->title}}
            </a>
        <a href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">
            {{$post->title}}
        </a>
        <p href="#" class="text-sm pb-3">
            Published on {{$post->getFormattedDate()}}
            {{-- By <a href="#" class="font-semibold hover:text-gray-800">David Grzyb</a>,  --}}
        </p>
        <a href="#" class="pb-6">
            {!! $post->short_content !!}
        </a>
        <a href="{{route('post.show', $post)}}" class="uppercase text-gray-800 hover:text-black">Продолжить чтение<i class="fas fa-arrow-right"></i></a>
    </div>
</article>