@props(['image'])

<a href="/images/{{ $image->id }}"
    class="flex flex-col gap-2 rounded-none sm:rounded bg-shadow text-white text-left hover:scale-100 sm:hover:scale-105 shadow">
    <img class="h-full w-full" src={{ asset("images/forest.jpg") }} alt="Forest">
    <h2 class="text-2xl font-bold p-4 hover:text-sunset leading-snug">
        {{ $image->title }}
    </h2>
    <x-tag :image="$image" />
    <p class="text-base font-bold p-4">
        {{ $image->author }}
    </p>
</a>