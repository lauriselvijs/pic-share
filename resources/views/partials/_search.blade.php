@php
$value = request()->query("search") ?? ""
@endphp

<form id="posts-search-form" action={{ route('posts.index') }}
    class='absolute flex justify-center items-center w-3/4 md:w-2/4 h-10 top-1/2 left-0 right-0 ml-auto mr-auto md:top-3/4'>
    <x-input.secondary id="posts-search-input" label='Search' type='text' name='search' placeholder='Search'
        required='false' :value="$value" />
    <button title="Search" id="submit-post-search" aria-label='Search' type="submit"
        class='cursor-pointer bg-black w-14 h-10 flex justify-center items-center fill-white hover:fill-sunset'>
        <svg class='w-4 h-4' viewBox='0 0 16 16'>
            <path
                d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
        </svg>
    </button>
    <button aria-label="Clear input" id="clear-posts-search-input" type="button"
        class="hidden absolute top-0 bottom-0 mb-auto mt-auto right-20 text-black bg-transparent hover:text-shadow">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
        </svg>
    </button>
</form>