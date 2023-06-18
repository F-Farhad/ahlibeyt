<x-app-layouts :meta-title="$post->title" :meta-description="Str::words(strip_tags($post->short_content), 40)">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <x-post-content :post="$post" routeName="category.showPost" :parametrsPrev="[$category, $prev]" :parametrsNext="[$category, $next]" :prev="$prev" :next="$next"/>
    </section>

    <x-side-bar />
    
</x-app-layouts>