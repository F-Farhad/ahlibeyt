<x-app-layouts meta-description="Ahlibeyt блог для мусульман СНГ">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        @foreach ($posts as $post)
            <x-tag-post-item :post="$post" :tag="$tag" />
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

    <x-tag-side-bar />

</x-app-layouts>