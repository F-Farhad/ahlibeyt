<aside class="w-full md:w-1/3 flex flex-col items-center px-3">
    <div class="w-full shadow flex flex-col my-4 p-6 bg-light rounded-sm">

        <h3 class="text-xl font-bold mb-1">{{$header}}</h3>
        <div class="table">
            @foreach ($collections as $item)
            <div class="inline-block">
                <a href="{{route($route, $item)}}" 
                    class="font-semibold block py-2 px-3 rounded hover:bg-primary hover:text-light
                        {{request($req)?->slug == $item->slug ? 'bg-primary text-light' : ''}} "> 
                    {{$item->title}} 
                </a>
            </div>
            @endforeach
        </div>

    </div>
</aside>



