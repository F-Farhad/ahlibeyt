<x-app-layouts :meta-title="$post->title" :meta-description="Str::words(strip_tags($post->short_content), 30) ">

        <section class="container max-w-5xl mx-auto px-3">
    
            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                    <img src="{{$post->getThumbnail()}}">
                <div class="bg-white flex flex-col justify-start p-6">
                    <a href="{{route('category.showAllPosts', $post->category)}}" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$post->category->title}}</a>
                    <h1 class="text-3xl font-bold"> {{ \App\Models\Post::getMarkedText($post->title, $searchExpression)}} </h1>
                    <div class="text-sm pb-4 ">
                        Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
                    </div>
                    <div>
                        {!!\App\Models\Post::getMarkedText($post->short_content, $searchExpression) !!}
                    </div>
                    <div>
                        @if($post->content)
                            @foreach(json_decode($post->content, true) as $content)
                                @if($content['type'] == 'content')
                                    {!! \App\Models\Post::getMarkedText($content['data']['content'], $searchExpression) !!}
                                @elseif($content['type'] == 'audio')
                                <div class="mb-3">
                                    <h3 class="mb-1 text-xl font-semibold">{!! \App\Models\Post::getMarkedText($content['data']['title'], $searchExpression) !!}</h3>
                                    <audio controls>
                                        <source src="/storage/{!!$content['data']['audio']!!}" type="audio/mpeg">
                                    </audio>
                                </div>
                                @elseif($content['type'] == 'image')
                                <div class="mb-3">
                                    <h3 class="mb-1 text-xl font-semibold">{!! \App\Models\Post::getMarkedText($content['data']['image_description'], $searchExpression)!!}</h3>
                                    <img class="rounded-md" src=" /storage/{!! $content['data']['image'] !!}" >
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="flex flex-row flex-wrap">
                        @foreach($post->tags as $tag)
                        <div class="mr-1 mt-1 hover:underline">
                            <a class="" href="{{route('tag.showAllPosts', $tag)}}">#{{$tag->title}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </article>

        </section>
    </x-app-layouts>