<!-- Sidebar Section -->
<aside class="w-full md:w-1/3 flex flex-col items-center px-3">

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