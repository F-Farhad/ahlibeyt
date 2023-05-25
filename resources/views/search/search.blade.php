<x-app-layouts meta-title="Найденные посты" meta-description="Поиск по сайту">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        @foreach ($posts as $post)
            <x-post-item :post="$post" />
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

    <x-side-bar />

</x-app-layouts>