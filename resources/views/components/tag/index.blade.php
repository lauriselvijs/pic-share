@props(["tagsCsv"])

@php
$tags = explode(", ", $tagsCsv);
@endphp

@unless (count($tags) == 0)
<ul {{ $attributes->merge(['class' => 'flex justify-start gap-2 text-base font-normal text-white']) }}>
    @foreach ( $tags as $tag)
    <li class="bg-black px-2 py-1 rounded-lg hover:text-sunset">
        <a href=" /?tag={{$tag}}">{{ $tag }}</a>
    </li>
    @endforeach
</ul>
@endunless