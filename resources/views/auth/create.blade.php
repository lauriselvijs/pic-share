@extends('layout.index')

@section('title')
{{ __('Sign Up')}}
@endsection

@section('content')

<x-card.logo>
    <x-slot name='heading'>
        {{ __('Create an account') }}
    </x-slot>
    <x-form.auth confirmPassword :action='route("auth.store")'>
        <x-slot name='fields'>
            <x-input label="{{ __('Your name') }}" name='name' placeholder="{{ __('John Doe') }}" required
                value="{{ old('name') }}" autocomplete="name" />
        </x-slot>
        <x-slot name='info'>
            <div class='flex items-center justify-between'>
                <x-input.checkbox name='agreement' required>
                    <x-slot name='label'>
                        @include('partials._terms')
                    </x-slot>
                </x-input.checkbox>
            </div>
            @error('agreement')
            <x-message.error aria-describedby='agreement'>
                {{ $message }}
            </x-message.error>
            @enderror
        </x-slot>
        <x-slot name='submit'>
            <x-button type='submit'>
                {{ __('Sign up') }}
            </x-button>
        </x-slot>
        <x-slot name='footer'>
            {{ __('Already have an account?') }} <x-link :href='route("auth.login")' class='font-medium'>{{ __('Sign in
                here')}}</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection