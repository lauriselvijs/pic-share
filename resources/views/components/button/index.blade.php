@props(['type',])

<button type={{ $type }} {{ $attributes->merge(['class' => 'w-full text-white bg-black hover:bg-shadow focus:outline
    focus:outline-4
    focus:outline-white font-medium text-base px-5 py-2.5 text-center active:bg-black']) }}
    >{{
    $slot }}</button>