<header
    class='h-20 md:h-10 px-6 md:px-40 bg-black text-base font-normal text-white flex sm:gap-8 gap-4 md:justify-end items-center transition-all overflow-x-auto overflow-y-hidden'
    x-data='{ openHamburgerMenuModal: false }'>
    @include('partials.button._modal-open')
    @include('partials._modal')
    <div
        class='flex justify-center sm:justify-start  items-center order-2 md:order-1 flex-1 font-bold text-4xl cursor-default'>
        <a href={{ route('home') }}>
            <img class='w-8 h-8 min-w-[2rem] min-h-[2rem] mr-2 cursor-pointer' src={{asset('assets/images/logo.png') }}
                alt='logo'></a>
        <a href={{ route('home')}}><span class='hover:text-sunset cursor-pointer'>PicShare</span></a>
    </div>
    <div class='md:flex md:order-2 hidden'>
        <x-nav hoverLinkColor='text-sunset' class='text-white' />
    </div>
    {{--
    TODO:
    [ ] - implement darkmode
    [ ] - @include('partials.button._dark-mode')
    --}}
</header>