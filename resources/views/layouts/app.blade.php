<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$metaTitle ?: 'Ahlibeyt'}}</title>
    <meta name="author" content="">
    <meta name="description" content="{{$metaDescription}}">

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script> --}}
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>

    <!-- Top Bar Nav -->
    <nav class="w-full py-4 bg-blue-800 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between">

            <nav>
                <div class="flex items-center justify-between font-bold text-sm text-white uppercase no-underline">
                    <div><a class="hover:text-gray-200 hover:underline px-4" href="#">Shop</a></div>
                    <div><a class="hover:text-gray-200 hover:underline px-4" href="#">About</a></div>
                </div>
            </nav>

            <div class="flex items-center text-lg no-underline text-white pr-6">
                <a class="" href="#">
                    <i class="fab fa-facebook"></i>
                </a>
                <a class="pl-6" href="#">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="pl-6" href="#">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="pl-6" href="#">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
        </div>

    </nav>

    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl" href="{{route('main')}}">
                Minimal Blog
            </a>
            <div class="text-lg text-gray-600">
                Lorem Ipsum Dolor Sit Amet
            </div>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a
                href="#"
                {{-- bg-green-400 --}}
                class=" md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                @click="open = !open"
            >
                Меню <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">
                <a href="{{route('main')}}" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">{{ __('ahlibeyt.main')}}</a>
                <a href="{{route('category.index')}}" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">{{ __('ahlibeyt.all_category')}}</a>
                <a href="{{route('post.index')}}" class="hover:bg-gray-400 rounded py-2 px-4 mx-2">{{ __('ahlibeyt.all-posts')}}</a>
                <a href="{{route('about-us')}}" class="hover:bg-gray-400 rounded py-2 px-4 mx-2 whitespace-nowrap">{{ __('ahlibeyt.about-us')}}</a>
                <form method="get" action="{{route('search')}}">
                    <input name="search_expression" value="{{request()->get('search_expression')}}"
                           class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6 font-medium"
                           placeholder="Поиск по сайту"/>
                </form>
            </div>
        </div>
    </nav>


    <div class="container mx-auto flex flex-wrap py-6">

    {{ $slot }}
        
    </div>

    <footer class="w-full border-t bg-white py-4">
        <div class="w-full container mx-auto flex flex-col items-center text-sm">
            <div class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-2">
                <a href="{{route('about-us')}}" class="uppercase px-3">{{__('ahlibeyt.about-us')}}</a>
                <a href="#" class="uppercase px-3">Contact Us</a>
            </div>
            <div class="uppercase pb-3">&copy; ahlibeyt.by</div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>