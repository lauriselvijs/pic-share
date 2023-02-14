@props(["tag"])


<li class="bg-black px-2 py-1 rounded-lg hover:text-sunset cursor-pointer text-center">
    <a href={{ request()->fullUrlWithQuery(['search' => $tag]) }}>{{ $tag }}</a>
</li>