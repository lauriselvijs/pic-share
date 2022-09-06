@props(["tag"])

@if (str_contains(Request::getRequestUri(), "&" . config('constants.TAG_URL_QUERY') . $tag))
<a href={{ str_replace("&" . config('constants.TAG_URL_QUERY') . $tag,"", Request::getRequestUri()) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@elseif(str_contains(Request::getRequestUri(), '?' . config('constants.TAG_URL_QUERY') . $tag . '&'))
<a href={{ str_replace('?' . config('constants.TAG_URL_QUERY') . $tag . '&' ,'?', Request::getRequestUri()) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@elseif(str_contains(Request::getRequestUri(), '?' . config('constants.TAG_URL_QUERY') . $tag))
<a href={{ str_replace('?' . config('constants.TAG_URL_QUERY') . $tag,'', Request::getRequestUri()) }}>
    <x-list.item>{{ $tag }} x</x-list.item>
</a>
@endif