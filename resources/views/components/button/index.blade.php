@props(["type"])

<button type={{ $type }}
    class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">{{
    $slot }}</button>