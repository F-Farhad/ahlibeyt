<x-app-layouts :meta-title="'Ahlibeyt - посты категории ' . $category->title" meta-description="Ahlibeyt блог для мусульман СНГ">
    <!-- Posts Section -->

    <div class="container mx-auto flex flex-wrap py-6">
        <section class="w-full md:w-2/3  px-3">
            <div class=" flex flex-col items-center">
                @foreach ($posts as $post)
                    <x-post-item :post="$post" :parametrs="[$category, $post]" routeName="category.showPost"/>
                @endforeach
            </div>
                {{$posts->onEachSide(1)->links()}}
        </section>

        <x-side-bar />
    </div>
</x-app-layouts>