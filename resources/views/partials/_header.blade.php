<header
    class="h-20 md:h-10 px-6 md:px-40 bg-black text-base font-normal text-white flex sm:gap-8 gap-4 justify-center md:justify-end items-center transition-all"
    x-data="{ openHamburgerMenuModal: false }">
    @include("partials.button._modal-open")
    @include("partials._modal")
    <div
        class="flex justify-center sm:justify-start  items-center order-2 md:order-1 md:flex-1 flex-1 font-bold text-4xl cursor-default">
        <a href="/">
            <img class="w-8 h-8 mr-2 cursor-pointer" src={{asset("assets/images/logo.png") }} alt="logo"></a>
        <a href="/"><span class="hover:text-sunset cursor-pointer">PicShare</span></a>
    </div>
    <nav class="md:flex md:order-2 hidden ">
        <ul class="md:flex gap-8 justify-between items-center whitespace-nowrap">
            @auth
            <li class="cursor-pointer hover:text-sunset"><a href="/images/create">Add new image</a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/images/my-images">My images</a></li>
            <li>Wellcome {{ auth()->user()->name }}</li>
            <li class="cursor-pointer hover:text-sunset"><a href="/sign-out">Sign out</a></li>
            @else
            <li class="cursor-pointer hover:text-sunset"><a href="/sign-up">Sign up</a></li>
            <li class="cursor-pointer hover:text-sunset"><a href="/login">Login</a></li>
            @endauth
        </ul>
    </nav>
    @include("partials.button._dark-mode")
</header>