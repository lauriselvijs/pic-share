@extends('layout.index')

@section('title')
{{ __('Sign Up') }}
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        {{ __('Reset password') }}
    </x-slot>
    <x-form :action='route("password.update")' method='POST'>
        @csrf

        {{-- TODO:
        [] - move inputs that repeat to a component --}}
        <x-input label="{{ __('Your email') }}" type='email' autocomplete="email" name='email'
            placeholder="{{ __('name@company.com') }}" required value="{{ old('email') }}" />

        <x-input autocomplete="new-password" label="{{ __('New password') }}" type='password' name='password'
            placeholder='••••••••' required />

        <x-input autocomplete="new-password" label="{{ __('Confirm new password') }}" type='password'
            name='password_confirmation' placeholder='••••••••' required />

        <input type='hidden' name='token' value="{{ $token }}" />

        <x-button type='submit'>
            {{ __('Reset password') }}
        </x-button>
    </x-form>
</x-card.logo>
@endsection