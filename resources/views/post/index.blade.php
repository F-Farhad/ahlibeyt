<x-app-layouts meta-title="Посты" meta-description="Все посты блога">
    <!-- Posts Section -->
    <section class="container max-w-5xl mx-auto px-3">

        @foreach ($posts as $post)
            <x-post-item :post="$post" />
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

</x-app-layouts>