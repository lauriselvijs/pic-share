<div class="bg-sunset">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
        <a href="/" class="flex items-center mb-6 text-2xl font-bold text-black">
            <img class="w-8 h-8 mr-2" src={{ asset("images/logo.png") }} alt="logo">
            PicShare
        </a>
        <div class="w-full bg-white shadow  sm:max-w-md">
            <div class="p-6 space-y-4 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2x">
                    {{ $heading }}
                </h1>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>