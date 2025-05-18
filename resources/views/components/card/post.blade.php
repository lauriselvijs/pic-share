@props(['post'])

{{--
BUG: Cant use a tag on outside div element,new a tag wraps around each of the inner element
--}}
<div
    class='flex flex-col gap-2 bg-shadow text-white text-left md:rounded-[32px] hover:rounded-none rounded-none shadow-md transition-all overflow-hidden'>
    <a href="{{ route('posts.show', $post->slug) }}">
        <img decoding="async" loading="lazy" class='h-full w-full' src={{$post->image}} alt='{{ __('Post') }}'
        title='{{ __('Post') }}'>
    </a>
    <div class="p-6 pb-24 md:pb-12 flex flex-col justify-center items-start">
        <a class="hover:text-sunset" href="{{ route('posts.show', $post->slug) }}">
            <h2 class='text-2xl font-bold  leading-snug pb-6'>
                {{ $post->title }}
            </h2>
        </a>

        <x-tag :tagsCsv='$post->tags' />

        <p class='text-base font-bold pt-4'>
            {{ $post->author }}
        </p>
    </div>
</div>