<div class='flex flex-col items-center justify-center px-6 py-8 mx-auto bg-sunset flex-1 w-full'>
    <a href={{ route('home')}} class='flex items-center mb-6 text-2xl font-bold text-black'>
        <img class='w-8 h-8 mr-2' src={{ asset('assets/images/logo.png') }} alt='logo'>
        <h2 class='text-4xl'>
            PicShare
        </h2>
    </a>
    <div class='w-full bg-white shadow  sm:max-w-md'>
        <div class='p-6 space-y-4 sm:p-8'>
            <h3 class='text-lg font-bold leading-tight tracking-tight text-black md:text-2x'>
                {{ $heading }}
            </h3>
            {{ $slot }}
        </div>
    </div>
</div>