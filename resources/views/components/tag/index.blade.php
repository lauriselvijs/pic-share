@props(['tagsCsv'])

@php
$tags = explode(', ', $tagsCsv);
@endphp


@unless (count($tags) == 0 || in_array("", $tags))
<ul class="flex justify-start gap-2 pl-4 text-base font-normal text-white">
    @foreach ( $tags as $tag)
    <x-tag.item :tag='$tag' />
    @endforeach
</ul>
@endunless