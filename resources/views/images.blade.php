@extends("layout")
@section("title")
Images
@endsection

@section("content")
<div>
    <div class="relative transition-all sm:block flex justify-center">
        <h1 class="absolute	text-shadow font-bold text-4xl sm:pt-4 sm:pl-40 pt-2 p-0 transition-all">Share your
            images</h1>
        <img class="h-full w-full hidden sm:block" src={{ asset("images/hero-desktop.png") }} alt="Mountains">
        <img class="h-full w-full block sm:hidden" src={{ asset("images/hero-mobile.png") }} alt="Mountains">
        <form class="absolute flex justify-center items-center w-full h-10 top-1/2 sm:top-3/4">
            <label for="simple-search" class="sr-only">Search</label>
            <input type="text" id="simple-search"
                class="bg-white text-black text-base w-full h-full p-1 pl-8 pr-10 ml-6 sm:ml-40" placeholder="Search"
                required>
            <button aria-label="Search"
                class="cursor-pointer bg-black w-14 h-10 flex justify-center items-center mr-6 sm:mr-40">
                <svg class=" fill-white hover:fill-sunset w-4 h-4" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </form>
    </div>

    @unless (count($images) == 0)
    <div
        class="grid md:grid-cols-3 grid-cols-1 gap-0 sm:gap-8 sm:pr-40 sm:pl-40 pr-0 pl-0 pt-0 pb-0 sm:pt-24 sm:pb-24 bg-sunset transition-all">
        @foreach ($images as $image)
        <a href="/images/{{ $image->id }}"
            class="flex flex-col gap-2 rounded-none sm:rounded bg-shadow text-white text-left hover:scale-100 sm:hover:scale-105 shadow">
            <img class="h-full w-full" src={{ asset("images/forest.jpg") }} alt="Forest">
            <h2 class="text-2xl font-bold p-4 hover:text-sunset leading-snug">
                {{ $image->title }}
            </h2>

            @php
            $tags = explode(", ", $image->tags);
            @endphp

            @unless (count( $tags) == 0)
            <div class="flex justify-start gap-2 px-4 text-base font-normal text-white">
                @foreach ( $tags as $tags)
                <p class="bg-black px-2 rounded-lg">{{ $tags }}</p>
                @endforeach
            </div>
            @endunless

            <p class="text-base font-bold p-4">
                {{ $image->author }}
            </p>
        </a>
        @endforeach
    </div>
</div>
@endunless

@endsection