@php
$value = request()->query("search") ?? ""
@endphp

<div id='post-search-container'
    class='absolute flex flex-col justify-center items-center w-3/4 md:w-2/4 top-1/2 left-0 right-0 ml-auto mr-auto md:top-3/4'>
    <form autocomplete='off' id='posts-search-form' action={{ route('posts.index') }}
        class='relative flex justify-center items-center h-10 w-full'>
        <x-input.secondary id="posts-search-input" label="{{ __('Search') }}" type='search' name='search'
            placeholder="{{ __('Search') }}" :value="$value" />
        @include('partials.button._search')
        @include('partials.button._clear')
    </form>
    <div id='post-search-suggestion-box'
        class='hidden w-full max-h-60 h-fit z-10 bg-sunset text-black text-base overflow-auto'>
        <ul id="post-search-suggestion-box-list" class='flex flex-col justify-center items-start'>
            <li id='post-search-suggestion-list-item'
                class='p-5 w-full h-full flex gap-2 justify-start items-baseline hover:bg-shadow hover:cursor-pointer hover:text-sunset hover:fill-sunset'>
                {{-- <svg class='w-4 h-4' viewBox='0 0 16 16'>
                    <path
                        d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
                </svg> --}}
            </li>
        </ul>
    </div>
</div>