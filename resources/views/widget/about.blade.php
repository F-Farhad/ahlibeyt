<x-app-layouts :meta-title="'Ahlibeyt ' . $pageAboutUs->title" :meta-description="Str::words(strip_tags($pageAboutUs->content), 40)">
    <!-- Post Section -->
        <section class="w-full flex flex-col items-center px-3">
    
            <article class="w-full flex flex-col shadow my-4">
                <!-- Article Image -->
                    <img src="/storage/{{$pageAboutUs->thumbnail}}" class="w-full">
                <div class="bg-white flex flex-col justify-start p-6">
                    <h1 class="text-3xl font-bold">{{$pageAboutUs->title}}</h1>
                    <div>
                        {!! $pageAboutUs->content !!}
                    </div>
                    <div class="flex flex-row flex-wrap">
                    </div>
                </div>
            </article>
        </section>
</x-app-layouts>