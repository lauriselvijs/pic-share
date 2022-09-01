@props(["type"])

<button type={{ $type }} class=" bg-sunset text-black font-bold text-xl w-36 shadow active:ring-4 active:ring-black">
    {{ $slot }}
</button>