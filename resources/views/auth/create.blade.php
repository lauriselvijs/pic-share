@extends('layout.index')

@section('title')
{{ __('Sign Up')}}
@endsection

@section('content')

<x-card.logo>
    <x-slot name='heading'>
        {{ __('Create an account') }}
    </x-slot>
    <x-form.auth confirmPassword='false' :action='route("auth.store")'>
        <x-slot name='extraInputFields'>
            <x-input label="{{ __('Your name') }}" type='text' name='name' placeholder="{{ __('John Doe') }}"
                required='required' value="{{ old('name') }}" />
            @error('name')
            <x-message.error>
                {{ $message }}
            </x-message.error>
            @enderror
        </x-slot>
        <x-slot name='addAuthFormInfo'>
            <div class='flex items-center justify-between'>
                <x-input.checkbox name='agreement' required='required'>
                    <x-slot name='checkboxLabel'>
                        @include('partials._terms')
                    </x-slot>
                </x-input.checkbox>
            </div>
            @error('agreement')
            <x-message.error>
                {{ $message }}
            </x-message.error>
            @enderror
        </x-slot>
        <x-slot name='submit'>
            <x-button type='submit'>
                {{ __('Sign up') }}
            </x-button>
        </x-slot>
        <x-slot name='authFormFooter'>
            {{ __('Already have an account?') }} <x-link :href='route("auth.login")' class='font-medium'>{{ __('Sign in
                here')}}</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection