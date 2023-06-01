<x-app-layouts meta-title="Ahlibeyt Blog" meta-description="Блог для сообщества мусульман стран СНГ">
    <div class="container max-w-7xl mx-auto px-3">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 bg-white shadow">
            <!-- Latest Post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pl-2 pb-1 border-b-2 border-blue-500 mb-3">
                    {{__('ahlibeyt.latestPost')}}
                </h2>

                @if ($latestPost)
                    <x-post-item :post="$latestPost" />
                @endif
            </div>

            <!--About us, Popular 3 post -->
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pl-2 pb-1 border-b-2 border-blue-500 mb-3">
                    {!! \App\Models\Widget::getTitle('short-about-us') !!}
                </h2>
                <div class="pl-2 pr-2">
                    {!! \App\Models\Widget::getContent('short-about-us') !!}
                </div>
                <a href="{{route('about-us')}}" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4 mb-3">
                    {{__('ahlibeyt.get_to_known_us')}}
                </a>

                
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pl-2 pb-1 border-b-2 border-blue-500 mb-3">
                    {{__('ahlibeyt.popularPosts')}}
                </h2>
                <div class="p-1">
                    @foreach($popularPosts as $post)
                        <div class="grid grid-cols-4 gap-2 mb-4 ">
                            <a href="{{route('post.show', $post)}}" class="pt-1">
                                <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}"/>
                            </a>
                            <div class="col-span-3">
                                <a href="{{route('post.show', $post)}}">
                                    <h3 class="text-sm uppercase whitespace-nowrap truncate">{{$post->title}}</h3>
                                </a>
                                <div class="flex gap-4 mb-2">
                                        <a href="{{route('category.showAllPosts', $post->category)}}" class="bg-blue-500 text-white p-1 rounded text-xs font-bold uppercase">
                                            {{$post->category->title}}
                                        </a>
                                </div>
                                <div class="text-sm">
                                    <a href="{{route('post.show', $post)}}">
                                        {{ strip_tags( Str::words($post->short_content, 10)) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Latest Categories -->

        @foreach($popularCategories as $category)
            <div>
                <a href="{{route('category.showAllPosts', $category)}}">
                    <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                        {{__('ahlibeyt.category')}} "{{$category->title}}"
                            <i class="fas fa-arrow-right"></i>
                    </h2>
                </a>

                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($category->publishedPosts($latestPost)->limit(3)->get() as $post)
                            <x-post-item :post="$post" />
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layouts>