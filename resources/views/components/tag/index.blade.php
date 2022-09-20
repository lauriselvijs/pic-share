@props(['tagsCsv'])

@php
$tags = explode(', ', $tagsCsv);
@endphp

@unless (count($tags) == 0 || in_array("", $tags))
<ul {{ $attributes->merge(['class' => 'flex justify-start gap-2 text-base font-normal text-white']) }}>
    @foreach ( $tags as $tag)
    <x-tag.util :tag='$tag' />
    @endforeach
</ul>
@endunless