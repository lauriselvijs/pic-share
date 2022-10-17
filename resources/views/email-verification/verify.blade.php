@extends('layout.index')

@section('title')
Verify Email
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
    </x-slot>
    <div class="flex justify-center items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width='48' height='48'>
            <path
                d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM48 128V150.1L220.5 291.7C241.1 308.7 270.9 308.7 291.5 291.7L464 150.1V127.1C464 119.2 456.8 111.1 448 111.1H64C55.16 111.1 48 119.2 48 127.1L48 128zM48 212.2V384C48 392.8 55.16 400 64 400H448C456.8 400 464 392.8 464 384V212.2L322 328.8C283.6 360.3 228.4 360.3 189.1 328.8L48 212.2z" />
        </svg>
    </div>
    <div class="flex flex-col items-center justify-center bg-white">
        <div class="max-w-xl px-5 text-center space-y-12">
            <h2 class="mb-2 text-4xl font-bold text-black">Check your inbox</h2>
            <p class="mb-2 text-lg text-black">We are glad, that you’re with us. We’ve sent you a verification link
                to
                the email address <span class="font-bold text-black">{{ auth()->user()->email }}</span>.</p>
        </div>
    </div>
    <x-form :action='route("verification.send")' method='POST'>
        @csrf
        <x-button type='submit'>
            Resend email verifcation
        </x-button>
    </x-form>
</x-card.logo>
@endsection