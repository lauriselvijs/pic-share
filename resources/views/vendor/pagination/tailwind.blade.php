@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span
            class="relative inline-flex items-center px-4 py-2 text-base font-medium text-black bg-transparent  cursor-default leading-5 rounded-md">
            {{-- {!! __('pagination.previous') !!} --}}
        </span>
        @else
        {{-- <a href="{{ $paginator->previousPageUrl() }}" --}} <a
            class="relative inline-flex items-center px-4 py-2 text-base font-medium text-black bg-transparent leading-5 rounded-md active:bg-black active:text-white">
            <svg aria-hidden="true" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                    clip-rule="evenodd"></path>
            </svg>
            Previous
        </a>
        @endif

        @if ($paginator->hasMorePages())
        {{-- <a href="{{ $paginator->nextPageUrl() }}" --}} <a
            class="relative inline-flex items-center px-4 py-2 ml-3 text-base font-medium text-black bg-transparent leading-5 rounded-md active:bg-black active:text-white">
            Next
            <svg aria-hidden="true" class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </a>
        @else
        <span
            class="relative inline-flex items-center px-4 py-2 ml-3 text-base font-medium text-black bg-transparent cursor-default leading-5 rounded-md">
            {{-- {!! __('pagination.next') !!} --}}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:flex-col sm:gap-2 sm:items-center sm:justify-between">
        <div>
            <p class="text-base text-black leading-5">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                <span class="font-bold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-bold">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-bold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                {{-- <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span
                        class="relative inline-flex items-center px-2 py-2 text-base font-medium text-black bg-transparent cursor-default rounded-l-md leading-5"
                        aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </span> --}}
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="relative inline-flex items-center px-2 py-2 text-base font-medium text-black bg-transparent rounded-l-md leading-5 hover:text-white hover:bg-shadow active:bg-black"
                    aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-base font-medium text-black bg-transparent  cursor-default leading-5">{{
                        $element }}</span>
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-base font-medium text-white bg-black  cursor-default leading-5">{{
                        $page }}</span>
                </span>
                @else
                <a href="{{ $url }}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-base font-medium text-black bg-transparent leading-5 hover:text-white hover:bg-shadow active:bg-black"
                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="relative inline-flex items-center px-2 py-2 -ml-px text-base font-medium text-black bg-transparent rounded-r-md leading-5 hover:bg-shadow hover:text-white active:bg-black"
                    aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                {{-- <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-base font-medium text-black bg-transparent cursor-default rounded-r-md leading-5"
                        aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </span> --}}
                @endif
            </span>
        </div>
    </div>
</nav>
@endif