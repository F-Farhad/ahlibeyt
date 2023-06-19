@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        {{-- <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div> --}}

        <div class="w-full flex pt-6 sm:hidden">
            <div class="w-1/2">
                @if($paginator->onFirstPage())
                    <span class="block w-full text-link bg-white shadow hover:shadow-md text-left p-6">
                        <div class="text-lg text-gray400 font-bold flex items-center">
                            <i class="fas fa-arrow-left pr-1"></i> 
                            {!! __('pagination.previous') !!}
                        </div>
                    </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" class="block w-full text-link bg-white shadow hover:shadow-md text-left p-6">
                    <div class="text-lg text-black font-bold flex items-center">
                        <i class="fas fa-arrow-left pr-1"></i> 
                        {!! __('pagination.previous') !!}
                    </div>
                </a>
                @endif
            </div>
            <div class="w-1/2">
                @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="block w-full text-link bg-white shadow hover:shadow-md text-right p-6">
                        <div class="text-lg text-black font-bold flex items-center justify-end">
                            {!! __('pagination.next') !!} 
                            <i class="fas fa-arrow-right pl-1"></i>
                        </div>
                    </a>
                @else
                    <span class="block w-full text-link bg-white shadow hover:shadow-md text-right p-6">
                        <div class="text-lg text-gray400 font-bold flex items-center justify-end">
                            {!! __('pagination.next') !!} 
                            <i class="fas fa-arrow-right pl-1"></i>
                        </div>
                    </span>
                @endif
            </div>
        </div>

        <div class="hidden sm:w-full sm:flex sm:items-center sm:justify-center">

            <div>
                <span class="relative z-0 inline-flex rounded-md">

                    {{-- Previous Page Link --}}
                    @if (!$paginator->onFirstPage())
                       <a href="{{ $paginator->previousPageUrl() }}" rel="next" class="h-10 w-10 font-semibold text-black hover:text-link text-sm flex items-center justify-center mr-3" aria-label="{{ __('pagination.next') }}">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {!! __('pagination.previous') !!}
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-primary bg-white cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="h-10 w-10 bg-hover font-semibold text-black text-sm flex items-center justify-center">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="h-10 w-10 font-semibold text-primary hover:bg-link hover:text-light text-sm flex items-center justify-center" aria-label="{{ __('Перейти на страницу :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="h-10 w-10 font-semibold text-black hover:text-link text-sm flex items-center justify-center ml-4" aria-label="{{ __('pagination.next') }}">
                            {!! __('pagination.next') !!}
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
