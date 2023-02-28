@props(['post'])

<div
    class='flex flex-col gap-2 rounded-none sm:rounded bg-shadow text-white text-left hover:scale-100 md:hover:scale-105 shadow-md transition-all'>
    <img class='h-full w-full' src={{ asset($post->image) }} alt='User image'>
    <div class="p-6 pb-24 md:pb-12 flex flex-col justify-center items-start">
        <h2 class='text-2xl font-bold  leading-snug hover:text-sunset pb-6'>
            <a href={{ route('posts.show', $post->id) }}>
                {{ $post->title }}
            </a>
        </h2>

        <x-tag :tagsCsv='$post->tags' />

        <p class='text-base font-bold pt-4'>
            {{ $post->author }}
        </p>
    </div>

</div>