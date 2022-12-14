@extends('layout.index')

@section('title')
Sign Up
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        Reset password
    </x-slot>
    <x-form :action='route("password.update")' method='POST'>
        @csrf

        {{-- TODO:
        [] - move inputs that repeat to a component --}}
        <x-input label='Your email' type='email' name='email' placeholder='name@company.com' required value="{{ old('
            email') }}" />
        @error('email')
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-input label='New password' type='password' name='password' placeholder='••••••••' required />
        @error('password')
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-input label='Confirm new password' type='password' name='password_confirmation' placeholder='••••••••'
            required />
        @error('password_confirmation')
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <input type='hidden' name='token' value={{ $token }} />

        <x-button type='submit'>
            Reset password
        </x-button>
    </x-form>
</x-card.logo>
@endsection