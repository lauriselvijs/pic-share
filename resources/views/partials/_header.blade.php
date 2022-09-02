<header
    class="h-20 sm:h-10 pr-6 pl-6 sm:pr-40 sm:pl-40 bg-black text-base font-normal text-white flex gap-8 justify-start sm:justify-end items-center transition-all"
    x-data="{ openHamburgerMenuModal: false }">
    @include("partials.button._modal-open")
    @include("partials._modal")
    <div class="flex items-center order-2 sm:order-1 sm:flex-1 flex-1 font-bold text-4xl cursor-default">
        <a href="/">
            <img class="w-8 h-8 mr-2 cursor-pointer" src={{asset("assets/images/logo.png") }} alt="logo"></a>
        <a href="/"><span class="hover:text-sunset cursor-pointer">PicShare</span></a>
    </div>
    <nav class="sm:flex sm:order-2 hidden ">
        <ul class="sm:flex gap-8 justify-between items-center whitespace-nowrap">
            <li class="cursor-pointer hover:text-sunset"><a href="/images/create">Add new image</a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/sign-up">Sign up</a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/login">Login</a></li>
        </ul>
    </nav>
    @include("partials.button._dark-mode")
</header>