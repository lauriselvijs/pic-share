<!-- Hamburger modal -->
<div id='modal-bg' aria-hidden='true'
    class='hidden fixed top-0 right-0 left-0 z-50 bg-shadow bg-opacity-40 backdrop-blur-sm'>
    <!-- Hamburger modal content -->
    <div id='modal-content' class='bg-sunset rounded-br-lg shadow h-screen w-0 overflow-hidden transition-all'>
        <!-- Hamburger modal header -->
        <div class='flex justify-between gap-8 items-center p-6 rounded-t border-b border-white'>
            @auth
            <h3 class='text-xl font-bold text-black'>{{ auth()->user()->name }}</h3>
            @else
            <h3 class='text-xl font-bold text-black'>
                Menu
            </h3>
            @endauth
            <x-button.close id='close-modal-btn' />
        </div>
        <!-- Hamburger modal body -->
        <nav class='p-6'>
            <x-nav.ul hoverLinkColor='text-shadow' class='text-black'>
                <x-slot name='addListItem'>
                </x-slot>
            </x-nav.ul>
        </nav>
    </div>
</div>