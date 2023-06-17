<x-app-layouts meta-title="Категории" meta-description="Ahlibeyt блог для мусульман СНГ список всех категорий">
    <!-- Posts Section -->
    <div class="container max-w-7xl mx-auto px-3">

        @foreach($categories as $category)
            <div>
                <a href="{{route('category.showAllPosts', $category)}}">
                    <h2 class="text-lg sm:text-xl font-bold text-primary uppercase pb-1 border-b-2 border-primary mb-3">
                        {{__('ahlibeyt.category')}} "{{$category->title}}"
                            <i class="fas fa-arrow-right"></i>
                    </h2>
                </a>

                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($category->publishedPosts()->limit(3)->get() as $post)
                            <x-post-item :post="$post" :parametrs="[$category, $post]" routeName="category.showPost"/>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</x-app-layouts>