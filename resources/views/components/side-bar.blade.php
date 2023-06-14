<aside class="w-full md:w-1/3 flex flex-col items-center px-3">
    <div class="w-full bg-white shadow flex flex-col my-4 p-6">

        <h3 class="text-xl font-semibold mb-1">{{$header}}</h3>
        <div class="table">
            @foreach ($collections as $item)
            <div class="inline-block">
                <a href="{{route($route, $item)}}" 
                    class="text-semibold block py-2 px-3 rounded hover:bg-gray-400 hover:text-white 
                        {{request($req)?->slug == $item->slug ? 'bg-gray-400 text-white' : ''}} "> 
                    {{$item->title}} 
                </a>
            </div>
            @endforeach
        </div>

    </div>
</aside>



