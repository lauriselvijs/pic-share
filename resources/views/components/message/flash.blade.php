@if (session()->has('message'))
<template x-if='true' x-data='{showMsg: false}'>
    <div x-show='showMsg'
        class='fixed top-8 z-10 p-4 mx-auto left-6 right-6  sm:left-1/4 sm:right-1/4 border-black border shadow-lg shadow-black rounded-lg bg-sunset/80 backdrop-blur-md'
        role='alert' x-transition
        x-init='setTimeout(() => showMsg = true, 100); setTimeout(() => showMsg = false, 3000)'>
        <div class='flex items-center'>
            <span class='sr-only'>Info</span>
            <h2 class='text-2xl font-medium text-black'> {{ session('message')['msgTitle'] }}</h2>
            <x-button.close onClick='showMsg = false' />
        </div>
        <p class='mt-2 mb-4 text-base text-black'>
            {{ session('message')['msgInfo'] }}
        </p>
    </div>
</template>
@endif