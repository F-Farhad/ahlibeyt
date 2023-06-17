



<x-app-layouts meta-title="{{__('ahlibeyt.about-us')}}" meta-description="Str::words(strip_tags({{ \App\Models\Widget::getWidget('page-about-us', 'content') }}), 20)" >

        <section class="container max-w-5xl mx-auto px-3">
            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                <img class="aspect-[16/9] object-contain" src="/storage/{{\App\Models\Widget::getWidget('page-about-us', 'thumbnail')}}" alt="{{\App\Models\Widget::getWidget('page-about-us', 'title')}}">
                <div class="bg-white p-6">
                    <h1 class="text-3xl font-bold">{{\App\Models\Widget::getWidget('page-about-us', 'title')}}</h1>
                    <div>
                        {!! \App\Models\Widget::getWidget('page-about-us', 'content') !!}
                    </div>
                </div>
            </article>
        </section>
        
</x-app-layouts>