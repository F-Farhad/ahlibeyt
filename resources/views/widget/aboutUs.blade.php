<x-app-layouts meta-title="{{__('ahlibeyt.about-us')}}" :meta-description="Str::words(strip_tags($pageAboutUs->content), 20)">

        <section class="container max-w-5xl mx-auto px-3">
            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                <img src="/storage/{{$pageAboutUs->thumbnail}}" alt="{{$pageAboutUs->title}}" class="aspect-[16/9] object-contain">
                <div class="bg-white p-6">
                    <h1 class="text-3xl font-bold">{{$pageAboutUs->title}}</h1>
                    <div>
                        {!! $pageAboutUs->content !!}
                    </div>
                </div>
            </article>
        </section>
        
</x-app-layouts>