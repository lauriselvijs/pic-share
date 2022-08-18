<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <title>PicShare - @yield('title')</title>
</head>



<body>
    <header
        class="h-20 sm:h-10 pr-6 pl-6 sm:pr-40 sm:pl-40 bg-black text-base font-normal text-white flex gap-8 justify-start sm:justify-end items-center transition-all"
        x-data="{ openHamburgerMenuModal: $persist(false) }">
        <button x-on:click="openHamburgerMenuModal = true" aria-label="Hamburger menu"
            class="order-1 block sm:hidden cursor-pointer">
            <svg class=" fill-white hover:fill-sunset w-8 h-8" viewBox="0 0 100 80">
                <rect width="100" height="20"></rect>
                <rect y="30" width="100" height="20"></rect>
                <rect y="60" width="100" height="20"></rect>
            </svg>
        </button>
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
                            <svg aria-hidden="true" class="w-5 h-5 viewBox=" 0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
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
        <div class="flex items-center order-2 sm:order-1 sm:flex-1 flex-none font-bold text-4xl cursor-default">
            <a href="/">
                <img class="w-8 h-8 mr-2 cursor-pointer" src={{asset("images/logo.png") }} alt="logo"></a>
            <a href="/"><span class="hover:text-sunset cursor-pointer">PicShare</span></a>
        </div>
        <ul class="sm:order-2 hidden sm:flex gap-8 justify-between items-center whitespace-nowrap">
            <li class="cursor-pointer hover:text-sunset"><a href="/new-image"> Add new image </a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/sign-up"> Sign up </a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/login">Login</a></li>
        </ul>
        <div class="order-3 flex-1 flex justify-end mx-8">
            <template x-if="true">
                <button class="fill-white hover:fill-sunset" aria-label="Dark mode" x-data="{darkMode: $persist(false)}"
                    x-on:click="darkMode = !darkMode">
                    <svg x-show="darkMode" width="24" height="24" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <title>Sun</title>
                        <path
                            d="M11 3a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0V3zm0 16a1 1 0 0 1 2 0v2a1 1 0 0 1-2 0v-2zm1-2a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-9-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2H3zm16 0a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2h-2zm-.707-8.707a1 1 0 0 1 1.414 1.414l-1.581 1.581a1 1 0 0 1-1.414-1.414l1.58-1.581zM5.707 19.707a1 1 0 1 1-1.414-1.414l1.581-1.581a1 1 0 1 1 1.414 1.414l-1.58 1.581zm-1.414-14a1 1 0 0 1 1.414-1.414l1.581 1.581a1 1 0 0 1-1.414 1.414l-1.581-1.58zm15.414 12.586a1 1 0 0 1-1.414 1.414l-1.581-1.581a1 1 0 0 1 1.414-1.414l1.581 1.58z" />
                    </svg>
                    <svg x-show="!darkMode" width="24" height="24" viewBox="0 0 16 16"
                        xmlns="http://www.w3.org/2000/svg">
                        <title>Moon</title>
                        <path
                            d="M13.2 11.9c-4.5 0-8.1-3.6-8.1-8.1 0-1.4 0.3-2.7 0.9-3.8-3.4 0.9-6 4.1-6 7.9 0 4.5 3.6 8.1 8.1 8.1 3.1 0 5.8-1.8 7.2-4.4-0.6 0.2-1.3 0.3-2.1 0.3zM8.1 15c-3.9 0-7.1-3.2-7.1-7.1 0-2.5 1.3-4.7 3.3-6-0.2 0.6-0.2 1.2-0.2 1.9 0 5 4.1 9.1 9.1 9.2-1.4 1.2-3.2 2-5.1 2z">
                        </path>
                    </svg>
                </button>
            </template>

        </div>
    </header>
    <main>
        @yield("content")
    </main>

    <div>

    </div>
    <footer class="bg-black text-white transition-all sm:px-40">
        <div class="grid grid-cols-2 gap-8 py-8 px-6 md:grid-cols-4">
            <div>
                <h2 class="mb-6 text-sm font-semibold uppercase">Company</h2>
                <ul>
                    <li class="mb-4">
                        <a href="#" class=" hover:underline">About</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Careers</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Brand Center</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Blog</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="mb-6 text-sm font-semibold uppercase">Help center</h2>
                <ul>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Discord Server</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Twitter</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Facebook</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Contact Us</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="mb-6 text-sm font-semibold  uppercase">Legal</h2>
                <ul class="">
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Privacy Policy</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Licensing</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="mb-6 text-sm font-semibold  uppercase">Download</h2>
                <ul class="">
                    <li class="mb-4">
                        <a href="#" class="hover:underline">iOS</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Android</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">Windows</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="hover:underline">MacOS</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="py-6 px-4 md:flex md:items-center md:justify-between">
            <span class="text-sm sm:text-center">© {{ date('Y') }} <a class="hover:text-sunset"
                    href="https://my-page.com/">PicShare™</a>.
                All Rights Reserved.
            </span>
            <div class="flex mt-4 space-x-6 sm:justify-center md:mt-0">
                <a href="#" class="hover:fill-sunset fill-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Facebook page</span>
                </a>
                <a href="#" class=" hover:fill-sunset fill-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Instagram page</span>
                </a>
                <a href="#" class=" hover:fill-sunset fill-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                    <span class="sr-only">Twitter page</span>
                </a>
                <a href="#" class=" hover:fill-sunset fill-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">GitHub account</span>
                </a>
            </div>
        </div>
    </footer>
</body>

</html>