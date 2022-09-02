@extends("layout.index")
@section("title")
{{ $image->title }}
@endsection
@section("content")

<div class="flex flex-col gap-2 sm:pl-40 sm:pr-40 pl-0 pr-0 pt-24 pb-24 bg-shadow text-white text-left">
    <img class="h-auto w-full scale-75" src={{ asset("assets/images/forest.jpg") }} alt="Forest">
    <h2 class="text-2xl font-bold p-4 leading-snug">
        {{ $image->title }}
    </h2>

    <x-tag :tagsCsv="$image->tags" />
    <p class="text-base font-bold p-4">
        {{ $image->author }}
    </p>
    <div class="self-end flex gap-8">
        <x-button.tertiary type="button">
            Delete
        </x-button.tertiary>
        <a href="/">
            <x-button.tertiary type="button">
                Back
            </x-button.tertiary>
        </a>
    </div>
</div>

@endsection