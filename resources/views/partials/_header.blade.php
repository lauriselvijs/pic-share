<header
    class="h-20 sm:h-10 pr-6 pl-6 sm:pr-40 sm:pl-40 bg-black text-base font-normal text-white flex gap-8 justify-start sm:justify-end items-center transition-all"
    x-data="{ openHamburgerMenuModal: false }">
    @include("partials._modal-open-btn")
    @include("partials._modal")
    <div class="flex items-center order-2 sm:order-1 sm:flex-1 flex-1 font-bold text-4xl cursor-default">
        <a href="/">
            <img class="w-8 h-8 mr-2 cursor-pointer" src={{asset("images/logo.png") }} alt="logo"></a>
        <a href="/"><span class="hover:text-sunset cursor-pointer">PicShare</span></a>
    </div>
    <ul class="sm:order-2 hidden sm:flex gap-8 justify-between items-center whitespace-nowrap">
        <li class="cursor-pointer hover:text-sunset"><a href="/new-image"> Add new image </a></li>
        <li class="cursor-pointer hover:text-sunset"><a href="/sign-up"> Sign up </a></li>
        <li class="cursor-pointer hover:text-sunset"><a href="/login">Login</a></li>
    </ul>
    @include("partials._dark-mode-btn")
</header>