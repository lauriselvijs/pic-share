<template x-if='true'>
    <!-- Hamburger modal -->
    {{-- TODO:
    [] - replace alpinejs with jqueary --}}
    <div id='hamburgerMenu' aria-hidden='true' x-show='openHamburgerMenuModal'
        class='md:hidden fixed top-0 right-0 left-0 z-50 bg-shadow bg-opacity-40 backdrop-blur-sm transition-all'>
        <!-- Hamburger modal content -->
        <div class='bg-sunset rounded-br-lg shadow h-screen w-full' x-show='openHamburgerMenuModal'
            x-transition:enter='transition-all duration-1000' x-transition:enter-start='w-0 opacity-0'
            x-transition:enter-end='w-full' x-transition:leave='transition-all duration-1000'
            x-transition:leave-start='w-full' x-transition:leave-end='w-0'>
            <!-- Hamburger modal header -->
            <div class='flex justify-between gap-8 items-center p-6 rounded-t border-b border-white'
                x-show='openHamburgerMenuModal' x-transition.opacity>
                @auth
                <h3 class='text-xl font-bold text-black'>{{ auth()->user()->name }}</h3>
                @else
                <h3 class='text-xl font-bold text-black'>
                    Menu
                </h3>
                @endauth
                <x-button.close onClick='openHamburgerMenuModal = false' />
            </div>
            <!-- Hamburger modal body -->
            <nav class='p-6' x-show='openHamburgerMenuModal' x-transition.opacity>
                <x-nav.ul hoverLinkColor='text-shadow' class='text-black'>
                    <x-slot name='addListItem'>
                    </x-slot>
                </x-nav.ul>
            </nav>
        </div>
    </div>
</template>