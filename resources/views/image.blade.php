@extends("layout")
@section("title")
{{ $image->title }}
@endsection
@section("content")

<div class="flex flex-col gap-2 sm:pl-40 sm:pr-40 pl-0 pr-0 pt-24 pb-24 bg-shadow text-white text-left">
    <img class="h-full w-full" src={{ asset("images/forest.jpg") }} alt="Forest">
    <h2 class="text-2xl font-bold p-4 leading-snug">
        {{ $image->title }}
    </h2>
    <div class="flex justify-start gap-2 px-4 text-base font-normal text-white">
        <p class="bg-black px-2 rounded-lg">History</p>
        <p class="bg-black px-2 rounded-lg">Art</p>
        <p class="bg-black px-2 rounded-lg">Forest</p>
    </div>
    <p class="text-base font-bold p-4">
        {{ $image->author }}
    </p>
    <a href="/" class="self-end">
        <button class="bg-sunset text-black font-bold text-xl w-36 shadow active:ring-4 active:ring-black"
            aria-label="Go back">
            Back
        </button>
    </a>
</div>

@endsection