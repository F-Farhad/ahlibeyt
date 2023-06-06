<x-app-layouts meta-title="Категории" meta-description="Ahlibeyt блог для мусульман СНГ список всех категорий">
    <!-- Posts Section -->
    <div class="container max-w-7xl mx-auto px-3">

        @foreach($categories as $category)
            <div>
                <a href="{{route('category.showAllPosts', $category)}}">
                    <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                        {{__('ahlibeyt.category')}} "{{$category->title}}"
                            <i class="fas fa-arrow-right"></i>
                    </h2>
                </a>

                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($category->publishedPosts()->limit(3)->get() as $post)
                            <x-category-post-item :post="$post" :category="$category" />
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</x-app-layouts>