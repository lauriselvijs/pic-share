@extends('layout.index')

@section('title')
{{ __('Sign Up') }}
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        {{ __('Reset password') }}
    </x-slot>
    <x-form :action='route("password.email")' method='POST'>
        @csrf

        <x-input label="{{ __('Your email') }}" type='email' name='email' placeholder="{{ __('name@company.com') }}"
            required />
        @error('email')
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-button type='submit'>
            {{ __('Send reset password link') }}
        </x-button>
    </x-form>
</x-card.logo>
@endsection