@props(['post'])

<div
    class='flex flex-col gap-2 rounded-none sm:rounded bg-shadow text-white text-left hover:scale-100 md:hover:scale-105 shadow-md pb-24 md:pb-12'>
    <img class='h-full w-full' src={{ asset($post->image) }} alt='User image'>
    <h2 class='text-2xl font-bold p-4 px-6 leading-snug hover:text-sunset'>
        <a href='/posts/{{ $post->id }}'>
            {{ $post->title }}
        </a>
    </h2>

    <x-tag :tagsCsv='$post->tags' class='px-6' />

    <p class='text-base font-bold p-4 pl-6'>
        {{ $post->author }}
    </p>
</div>