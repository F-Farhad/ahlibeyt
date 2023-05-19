<x-app-layouts :meta-title="$post->title" :meta-description="Str::words(strip_tags($post->short_content), 40)">
    <!-- Post Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">
    
            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                    <img src="{{$post->getThumbnail()}}">
                <div class="bg-white flex flex-col justify-start p-6">
                    <a href="{{route('category.index', $post->category)}}" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$post->category->title}}</a>
                    <h1 class="text-3xl font-bold">{{$post->title}}</h1>
                    <p class="text-sm pb-4 ">
                        Опубликовано {{$post->getFormattedDate()->day .' '. $post->getFormattedDate()->getTranslatedMonthName('Do MMMM') . ' ' . $post->getFormattedDate()->year;}}
                    </p>
                    <div>
                        {!!$post->short_content!!}
                    </div>
                    <div>
                        @if($post->content)
                            @foreach(json_decode($post->content, true) as $content)
                                @if($content['type'] == 'content')
                                    {!! $content['data']['content'] !!}
                                @elseif($content['type'] == 'audio')
                                    {!! $content['data']['title'] !!}
                                    <audio controls>
                                        <source src="/storage/{!!$content['data']['audio']!!}" type="audio/mpeg">
                                    </audio>
                                @elseif($content['type'] == 'image')
                                    {!! $content['data']['image_description'] !!}
                                    <img src=" /storage/{!! $content['data']['image'] !!}" >
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="flex flex-row flex-wrap">
                        @foreach($post->tags as $tag)
                        <div class="mr-1 mt-1 hover:text-gray-700 pb-4">
                            <a href="{{route('tag.index', $tag)}}">{{$tag->title}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </article>
    
            <div class="w-full flex pt-6">
                <div class="w-1/2">
                    @if($prev)
                        <a href="{{route('post.show', $prev)}}" class="block w-full bg-white shadow hover:shadow-md text-left p-6">
                            <p class="text-lg text-blue-800 font-bold flex items-center">
                                <i class="fas fa-arrow-left pr-1"></i> 
                                Предыдущий
                            </p>
                            <p class="pt-2">{{\Illuminate\Support\Str::words($prev->title, 2) }}</p>
                        </a>
                    @endif
                </div>
                <div class="w-1/2">
                    @if($next)
                        <a href="{{route('post.show', $next)}}" class="block w-full bg-white shadow hover:shadow-md text-right p-6">
                            <p class="text-lg text-blue-800 font-bold flex items-center justify-end">
                                Следующий 
                                <i class="fas fa-arrow-right pl-1"></i>
                            </p>
                            <p class="pt-2">{{\Illuminate\Support\Str::words($next->title, 2) }}</p>
                        </a>
                    @endif
                </div>
            </div>
    
            {{-- <div class="w-full flex flex-col text-center md:text-left md:flex-row shadow bg-white mt-10 mb-10 p-6">
                <div class="w-full md:w-1/5 flex justify-center md:justify-start pb-4">
                    <img src="https://source.unsplash.com/collection/1346951/150x150?sig=1" class="rounded-full shadow h-32 w-32">
                </div>
                <div class="flex-1 flex flex-col justify-center md:justify-start">
                    <p class="font-semibold text-2xl">David</p>
                    <p class="pt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel neque non libero suscipit suscipit eu eu urna.</p>
                    <div class="flex items-center justify-center md:justify-start text-2xl no-underline text-blue-800 pt-4">
                        <a class="" href="#">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a class="pl-4" href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="pl-4" href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="pl-4" href="#">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div> --}}
        </section>

        <x-side-bar />
    </x-app-layouts>