@props(['image'])

<div
    class="flex flex-col gap-2 rounded-none sm:rounded bg-shadow text-white text-left hover:scale-100 sm:hover:scale-105 shadow">
    <img class="h-full w-full" src={{ asset("images/forest.jpg") }} alt="Forest">
    <h2 class="text-2xl font-bold p-4 leading-snug hover:text-sunset">
        <a href="/images/{{ $image->id }}">
            {{ $image->title }}
        </a>
    </h2>

    <x-tag :tagsCsv="$image->tags" />
    <p class="text-base font-bold p-4">
        {{ $image->author }}
    </p>
</div>