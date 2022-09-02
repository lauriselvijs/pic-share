@props(["type"])

<button type={{ $type }}
    class="py-2.5 flex justify-center gap-4 items-center border border-solid border-black w-full bg-white text-black hover:bg-sunset active:bg-white font-medium text-base">
    {{ $slot }}
</button>