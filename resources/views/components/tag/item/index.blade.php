@props(["tag"])

@php
$requestUri = Request::getRequestUri()
@endphp

<li class="bg-black px-2 py-1 rounded-lg hover:text-sunset">
    {{-- if tag exists in tag query string --}}
    @if(str_contains($requestUri, config('constants.TAG_QUERY_STRING') . $tag))
    <a href={{ $requestUri }}>{{ $tag }}</a>
    {{-- if tag query string exists but without this tag --}}
    @elseif (str_contains($requestUri, config('constants.TAG_QUERY_STRING')))
    <a href={{ $requestUri . "&" .config('constants.TAG_QUERY_STRING') . $tag}}>{{ $tag }}</a>
    {{-- if tag in tag query string does not exists --}}
    @elseif(str_contains($requestUri, config('constants.TAG_QUERY_STRING')) == false)
    <a href={{ $requestUri . "/?" .config('constants.TAG_QUERY_STRING') . $tag}}>{{ $tag }}</a>
    @endif
</li>