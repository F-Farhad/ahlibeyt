<x-app-layouts meta-title="Ahlibeyt" :meta-description="'На странице перечислены все посты тега ' . $tag->title">
    <!-- Posts Section -->

    <div class="container mx-auto flex flex-wrap py-6">
        <section class="w-full md:w-2/3  px-3">
            <div class=" flex flex-col items-center">
                @foreach ($posts as $post)
                    <x-post-item :post="$post" :parametrs="[$tag, $post]" routeName="tag.showPost"/>
                @endforeach
            </div>
                {{$posts->onEachSide(1)->links()}}
        </section>

        <x-tag-side-bar />
    </div>
</x-app-layouts>