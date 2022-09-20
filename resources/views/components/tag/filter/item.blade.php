@props(["tag"])

@php
$requestUri = urldecode(Request::getRequestUri());

$tagQuery = config('constants.TAG_QUERY_STRING') . $tag;
$firstAndOnlyTagInQueryString = '?' . $tagQuery;
$firstTagNotOnlyInQueryString = $firstAndOnlyTagInQueryString . '&';
$nTagInQueryString = '&' . $tagQuery;
@endphp

{{-- // TODO:
[] - move to php util functions --}}

{{-- if tag exists in tag query --}}
@if (str_contains($requestUri, $nTagInQueryString))
<a href={{ str_replace($nTagInQueryString,'', $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
{{-- if tag exists, is first and another tag follows in tag query --}}
@elseif(str_contains($requestUri, $firstTagNotOnlyInQueryString))
<a href={{ str_replace($firstTagNotOnlyInQueryString ,'?', $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
{{-- if tag exists in tag query and is first--}}
@elseif(str_contains($requestUri, $firstAndOnlyTagInQueryString))
<a href={{ str_replace($firstAndOnlyTagInQueryString,'', $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@endif