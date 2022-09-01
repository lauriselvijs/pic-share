@props(["action"])

<form action={{ $action }} class="absolute flex justify-center items-center w-full h-10 top-1/2 sm:top-3/4">
    {{ $slot }}
</form>