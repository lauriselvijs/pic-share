@props(["tag"])

@php
$requestUri = Request::getRequestUri()
@endphp

@if (str_contains($requestUri, "&" . config('constants.TAG_QUERY_STRING') . $tag))
<a href={{ str_replace("&" . config('constants.TAG_QUERY_STRING') . $tag,"", $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@elseif(str_contains($requestUri, '?' . config('constants.TAG_QUERY_STRING') . $tag . '&'))
<a href={{ str_replace('?' . config('constants.TAG_QUERY_STRING') . $tag . '&' ,'?', $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@elseif(str_contains($requestUri, '?' . config('constants.TAG_QUERY_STRING') . $tag))
<a href={{ str_replace('?' . config('constants.TAG_QUERY_STRING') . $tag,'', $requestUri) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@endif