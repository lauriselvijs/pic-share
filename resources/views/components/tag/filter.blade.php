@props(['tagsCsv' => '[]'])

@if ($tagsCsv !== '[]' && is_array($tagsCsv))
@unless (count($tagsCsv) == 0)
<ul {{ $attributes->merge(['class' => 'flex justify-start gap-2 text-base font-normal text-white ']) }}>
    @foreach ( $tagsCsv as $tag)
    <x-tag.util.filter :tag='$tag' />
    @endforeach
</ul>
@endunless
@endif