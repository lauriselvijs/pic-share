@props(["tag"])

@php
$requestUri = Request::getRequestUri()
@endphp

<li class="bg-black px-2 py-1 rounded-lg hover:text-sunset">
    @if(str_contains($requestUri, config('constants.TAG_QUERY_STRING') . $tag))
    <a href="{{ $requestUri }}">{{ $tag }}</a>
    @elseif (str_contains($requestUri, config('constants.TAG_QUERY_STRING')))
    <a href="{{ $requestUri }}&{{config('constants.TAG_QUERY_STRING') . $tag}}">{{ $tag }}</a>
    @elseif(str_contains($requestUri, config('constants.TAG_QUERY_STRING')) == false)
    <a href="/?{{config('constants.TAG_QUERY_STRING') . $tag}}">{{ $tag }}</a>
    @endif
</li>