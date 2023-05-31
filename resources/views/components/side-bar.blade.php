<!-- Sidebar Section -->
<aside class="w-full md:w-1/3 flex flex-col items-center px-3">

    {{-- <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5">
            {!! \App\Models\Widget::getTitle('short-about-us') !!}
        </p>
        <p class="pb-2">
            {!! \App\Models\Widget::getContent('short-about-us') !!}
        </p>
        <a href="{{route('about-us')}}" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
            {{__('ahlibeyt.get_to_known_us')}}
        </a>
    </div> --}}

    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
    
        <h3 class="text-xl font-semibold mb-2">{{__('ahlibeyt.all_category')}}</h3>
        @foreach ($categories as $category)
        <a href="{{route('category.showAllPosts', $category)}}" 
                class="text-semibold block py-2 px-3 rounded hover:bg-gray-400 hover:text-white 
                     {{request('category')?->slug == $category->slug ? 'bg-gray-400 text-white' : ''}} ">   {{-- mark category if inside --}}
            {{$category->title}} {{--({{$category->total}}) --}}
        </a>
        @endforeach

    </div>
</aside>