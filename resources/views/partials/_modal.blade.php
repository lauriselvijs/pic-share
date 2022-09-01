<template x-if="true">
    <!-- Hamburger modal -->
    <div id="hamburgerMenu" aria-hidden="true" x-show="openHamburgerMenuModal"
        class="sm:hidden fixed top-0 right-0 left-0 z-50 bg-shadow bg-opacity-40 backdrop-blur-sm transition-all">
        <!-- Hamburger modal content -->
        <div class="bg-sunset rounded-br-lg shadow h-screen w-1/2" x-show="openHamburgerMenuModal"
            x-transition:enter="transition-all duration-300" x-transition:enter-start="w-0 opacity-0"
            x-transition:enter-end="w-1/2" x-transition:leave="transition-all duration-300"
            x-transition:leave-start="w-1/2" x-transition:leave-end="w-0">
            <!-- Hamburger modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b border-white"
                x-show="openHamburgerMenuModal" x-transition.opacity>
                <h3 class="text-xl font-bold text-black">
                    Menu
                </h3>
                <button type="button" x-on:click="openHamburgerMenuModal = false"
                    class="text-black bg-transparent hover:bg-shadow hover:text-sunset rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="hamburgerMenu">
                    <svg aria-hidden="true" class="w-5 h-5 viewBox=" 0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" fill="currentColor"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Hamburger modal body -->
            <div class="p-6" x-show="openHamburgerMenuModal" x-transition.opacity>
                <ul class="text-black">
                    <li class="cursor-pointer hover:text-shadow"><a href="/sign-up"> Sign up </a></li>
                    <li class="cursor-pointer hover:text-shadow"><a href="/login">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>