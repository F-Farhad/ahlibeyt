<x-app-layouts :meta-title="'Ahlibeyt - посты категории ' . $category->title" meta-description="Ahlibeyt блог для мусульман СНГ">
    <!-- Posts Section -->
    <div class="flex">
        <section class="w-full md:w-2/3 flex flex-col px-3">

            @foreach ($posts as $post)
                <x-category-post-item :post="$post" :category="$category" />
            @endforeach

            {{$posts->onEachSide(1)->links()}}

        </section>

        <x-side-bar />
    </div>
</x-app-layouts>