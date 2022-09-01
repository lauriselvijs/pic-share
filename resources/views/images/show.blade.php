@extends("sections.layout")
@section("title")
{{ $image->title }}
@endsection
@section("content")

<div class="flex flex-col gap-2 sm:pl-40 sm:pr-40 pl-0 pr-0 pt-24 pb-24 bg-shadow text-white text-left">
    <img class="h-auto w-full scale-75" src={{ asset("images/forest.jpg") }} alt="Forest">
    <h2 class="text-2xl font-bold p-4 leading-snug">
        {{ $image->title }}
    </h2>

    @php
    $tags = explode(", ", $image->tags);
    @endphp

    <x-tag :tags="$tags" />
    <p class="text-base font-bold p-4">
        {{ $image->author }}
    </p>
    <div class="self-end flex gap-8">
        <button class=" bg-sunset text-black font-bold text-xl w-36 shadow active:ring-4 active:ring-black">
            Delete
        </button>
        <a href="/">
            <button class="bg-sunset text-black font-bold text-xl w-36 shadow active:ring-4 active:ring-black">
                Back
            </button>
        </a>
    </div>
</div>

@endsection