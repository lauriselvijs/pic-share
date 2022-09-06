@props(["tag"])

<li class="bg-black px-2 py-1 rounded-lg hover:text-sunset">
    @if(str_contains(Request::getRequestUri(), config('constants.TAG_URL_QUERY') . $tag))
    <a href="{{ Request::getRequestUri() }}">{{ $tag }}</a>
    @elseif (str_contains(Request::getRequestUri(), config('constants.TAG_URL_QUERY')))
    <a href="{{ Request::getRequestUri() }}&{{config('constants.TAG_URL_QUERY') . $tag}}">{{ $tag }}</a>
    @elseif(str_contains(Request::getRequestUri(), config('constants.TAG_URL_QUERY')) == false)
    <a href="/?{{config('constants.TAG_URL_QUERY') . $tag}}">{{ $tag }}</a>
    @endif
</li>