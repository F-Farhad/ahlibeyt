<article class="flex flex-col shadow my-4">

    <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}" class="aspect-[16/9] object-contain">    
    <div class="bg-white flex flex-col justify-start p-6">
        <a href="{{route('category.showAllPosts', $post->category)}}" class="text-link text-sm font-bold uppercase pb-4">{{$post->category->title}}</a>
        
        <h1 class="text-3xl font-bold">{{$post->title}}</h1>
        
        <div class="text-sm pb-4 ">
            Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
        </div>
        
        <div>
            {!!$post->short_content!!}
        </div>
        
        <div>
            @if($post->content)
                @foreach(json_decode($post->content, true) as $content)
                    @if($content['type'] == 'content')
                        {!! $content['data']['content'] !!}
                    @elseif($content['type'] == 'audio')
                    <div class="mb-3">
                        <h3 class="mb-1 text-xl font-semibold">{!! $content['data']['title'] !!}</h3>
                        <audio controls>
                            <source src="/storage/{!!$content['data']['audio']!!}" type="audio/mpeg">
                        </audio>
                    </div>
                    @elseif($content['type'] == 'image')
                    <div class="mb-3">
                        <h3 class="mb-1 text-xl font-semibold">{!! $content['data']['image_description'] !!}</h3>
                        <img class="aspect-[16/9] object-contain" src=" /storage/{!! $content['data']['image'] !!}" alt="{!! $content['data']['image_description'] !!}">
                    </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="flex flex-row flex-wrap">
            @foreach($post->tags as $tag)
            <div class="mr-1 mt-1 hover:underline">
                <a class="text-link uppercase text-xs" href="{{route('tag.showAllPosts', $tag)}}">#{{$tag->title}}</a>
            </div>
            @endforeach
        </div>

    </div>
</article>

<div class="w-full flex pt-6">
    <div class="w-1/2">
        @if($prev)
            <a href="{{route($routeName, $parametrsPrev)}}" class="block w-full text-link bg-white shadow hover:shadow-md text-left p-6">
                <div class="text-lg text-black font-bold flex items-center">
                    <i class="fas fa-arrow-left pr-1"></i> 
                    Предыдущий
                </div>
                <div class="pt-2 whitespace-nowrap">{{\Illuminate\Support\Str::limit($prev->title, 15) }}</div>
            </a>
        @endif
    </div>
    <div class="w-1/2">
        @if($next)
            <a href="{{route($routeName, $parametrsNext)}}" class="block w-full text-link bg-white shadow hover:shadow-md text-right p-6">
                <div class="text-lg text-black font-bold flex items-center justify-end">
                    Следующий 
                    <i class="fas fa-arrow-right pl-1"></i>
                </div>
                <div class="pt-2 whitespace-nowrap">{{\Illuminate\Support\Str::limit($next->title, 15) }}</div>
            </a>
        @endif
    </div>
</div>