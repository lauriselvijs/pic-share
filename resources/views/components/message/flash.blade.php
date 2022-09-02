@if (session()->has("message"))
<template x-if="true" x-data="{showMsg: false}">
    <div x-show="showMsg"
        class="fixed top-8 z-10 p-4 mx-auto left-6 right-6  sm:left-1/4 sm:right-1/4 border-black border shadow-lg shadow-black rounded-lg bg-sunset/80 backdrop-blur-md"
        role="alert" x-transition
        x-init="setTimeout(() => showMsg = true, 100); setTimeout(() => showMsg = false, 3000)">
        <div class="flex items-center">
            <svg aria-hidden="true" class="w-5 h-5 mr-2 text-black" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <h2 class="text-2xl font-medium text-black"> {{ session("message")["msgTitle"] }}</h2>
            <x-button.close onClick="showMsg = false" />
        </div>
        <p class="mt-2 mb-4 text-base text-black">
            {{ session("message")["msgInfo"] }}
        </p>
    </div>
</template>
@endif