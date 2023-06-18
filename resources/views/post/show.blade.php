<x-app-layouts :meta-title="$post->title" :meta-description="Str::words(strip_tags($post->short_content), 30)">

    <section class="container max-w-5xl mx-auto px-3">
        <x-post-content :post="$post" routeName="post.show" :parametrsPrev="$prev" :parametrsNext="$next" :prev="$prev" :next="$next"/>    
    </section>

</x-app-layouts>