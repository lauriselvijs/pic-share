@props(["type"])

<button type={{ $type }}
    class="flex justify-center gap-2 items-center bg-sunset text-black font-bold text-xl w-36 p-2 rounded-lg shadow-md hover:text-white hover:bg-black active:bg-sunset active:text-black fill-black hover:fill-white active:fill-black">
    {{ $slot }}
</button>