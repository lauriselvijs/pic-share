<template x-if="true">
    <!-- Hamburger modal -->
    <div id="hamburgerMenu" aria-hidden="true" x-show="openHamburgerMenuModal"
        class="md:hidden fixed top-0 right-0 left-0 z-50 bg-shadow bg-opacity-40 backdrop-blur-sm transition-all">
        <!-- Hamburger modal content -->
        <div class="bg-sunset rounded-br-lg shadow h-screen w-fit" x-show="openHamburgerMenuModal"
            x-transition:enter="transition-all duration-300" x-transition:enter-start="w-0 opacity-0"
            x-transition:enter-end="w-1/2" x-transition:leave="transition-all duration-300"
            x-transition:leave-start="w-1/2" x-transition:leave-end="w-0">
            <!-- Hamburger modal header -->
            <div class="flex justify-between gap-8 items-start p-4 rounded-t border-b border-white"
                x-show="openHamburgerMenuModal" x-transition.opacity>
                @auth
                <h3 class="text-xl font-bold text-black">{{ auth()->user()->name }}</h3>
                @else
                <h3 class="text-xl font-bold text-black">
                    Menu
                </h3>
                @endauth
                <x-button.close onClick="openHamburgerMenuModal = false" />
            </div>
            <!-- Hamburger modal body -->
            <div class="p-6" x-show="openHamburgerMenuModal" x-transition.opacity>
                <ul class="text-black flex flex-col justify-center items-start gap-8">
                    @auth
                    <li class="cursor-pointer hover:text-shadow"><a href="/images/create">Add new image</a></li>
                    <li class="cursor-pointer hover:text-shadow"><a href="/images/my-images">My images</a></li>
                    <li class="cursor-pointer hover:text-shadow"><a href="/sign-out">Sign out</a></li>
                    @else
                    <li class="cursor-pointer hover:text-shadow"><a href="/sign-up">Sign up</a></li>
                    <li class="cursor-pointer hover:text-shadow"><a href="/login">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</template>