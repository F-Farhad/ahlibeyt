<x-app-layouts :meta-title="'Ahlibeyt - посты категории ' . $category->title" meta-description="Ahlibeyt блог для мусульман СНГ">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        @foreach ($posts as $post)
            <x-category-post-item :post="$post" :category="$category" />
        @endforeach

        {{$posts->onEachSide(1)->links()}}

    </section>

    <x-side-bar />

</x-app-layouts>