@props(['post'])

<div
    class='flex flex-col gap-2 bg-shadow text-white text-left hover:md:rounded-[32px] rounded-none shadow-md transition-all'>
    <a href={{ route('posts.show', $post->slug) }}>
        <img decoding="async" loading="lazy" class='h-full w-full hover:md:rounded-t-[32px] rounded-none transition-all'
            src={{ asset($post->image) }}
        alt='Post' title='Post'>
        <div class="p-6 pb-24 md:pb-12 flex flex-col justify-center items-start">
            <h2 class='text-2xl font-bold  leading-snug hover:text-sunset pb-6'>
                {{ $post->title }}
            </h2>

            <x-tag :tagsCsv='$post->tags' />

            <p class='text-base font-bold pt-4'>
                {{ $post->author }}
            </p>
        </div>
    </a>
</div>