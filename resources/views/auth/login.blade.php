@extends('layout.index')

@section('title')
{{ __('Login') }}
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        {{ __('Login to your account') }}
    </x-slot>
    <x-form.auth :action='route("auth.authenticate")'>
        <x-slot name='extraInputFields'>
        </x-slot>
        <x-slot name='addAuthFormInfo'>
            <div class='flex items-center justify-between'>
                <x-input.checkbox name='remember' required=''>
                    <x-slot name='checkboxLabel'>
                        {{ __('Remember me') }}
                    </x-slot>
                </x-input.checkbox>
                <x-link :href='route("password.request")' class='text-sm font-medium text-black hover:underline'>
                    {{ __('Forgot password?') }}</x-link>
            </div>
        </x-slot>
        <x-slot name='submit'>
            <x-button type='submit'>
                {{ __('Login') }}
            </x-button>
        </x-slot>
        <x-slot name='authFormFooter'>
            {{ __("Don't have an account yet?") }} <x-link :href='route("auth.create")'
                class='font-medium text-black hover:underline'>
                {{ __('Sign up') }}</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection