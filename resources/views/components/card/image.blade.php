@props(['image'])

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