<x-app-layouts :meta-title="$post->title" :meta-description="Str::words(strip_tags($post->short_content), 40)">
    <!-- Post Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">
    
            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                    <img src="{{$post->getThumbnail()}}">
                <div class="bg-white flex flex-col justify-start p-6">
                    <a href="{{route('category.showAllPosts', $post->category)}}" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$post->category->title}}</a>
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
                                    <img class="rounded-md" src=" /storage/{!! $content['data']['image'] !!}" >
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="flex flex-row flex-wrap">
                        @foreach($post->tags as $tag)
                        <div class="mr-1 mt-1 hover:underline">
                            <a href="{{route('tag.showAllPosts', $tag)}}">#{{$tag->title}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </article>

            <div class="w-full flex pt-6">
                <div class="w-1/2">
                    @if($prev)
                        <a href="{{route('category.showPost', [$category, $prev])}}" class="block w-full bg-white shadow hover:shadow-md text-left p-6">
                            <div class="text-lg text-blue-800 font-bold flex items-center">
                                <i class="fas fa-arrow-left pr-1"></i> 
                                Предыдущий
                            </div>
                            <div class="pt-2">{{\Illuminate\Support\Str::words($prev->title, 2) }}</div>
                        </a>
                    @endif
                </div>
                <div class="w-1/2">
                    @if($next)
                        <a href="{{route('category.showPost', [$category, $next])}}" class="block w-full bg-white shadow hover:shadow-md text-right p-6">
                            <div class="text-lg text-blue-800 font-bold flex items-center justify-end">
                                Следующий 
                                <i class="fas fa-arrow-right pl-1"></i>
                            </div>
                            <div class="pt-2">{{\Illuminate\Support\Str::words($next->title, 2) }}</div>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <x-side-bar />
    </x-app-layouts>