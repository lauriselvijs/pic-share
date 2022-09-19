@extends("layout.index")

@section("title")
Sign Up
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Reset password
    </x-slot>
    <x-form action="/password-reset/reset-password" method="POST">
        @csrf

        <x-input label="Your email" type="email" name="email" placeholder="name@company.com" required="true"
            value="{{ old('email') }}" />
        @error("email")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-input label="Password" type="password" name="password" placeholder="••••••••" required="true" />
        @error("password")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-input label='Confirm password' type='password' name='password_confirmation' placeholder='••••••••'
            required='required' />
        @error("password_confirmation")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <input type='hidden' name='token' value={{ $token }} />

        <x-button type="submit">
            Reset password
        </x-button>
    </x-form>
</x-card.logo>
@endsection