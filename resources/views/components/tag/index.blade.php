@props(["image"])

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