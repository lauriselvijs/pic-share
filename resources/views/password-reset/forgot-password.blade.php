@extends("layout.index")

@section("title")
Sign Up
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Reset password
    </x-slot>
    <x-form action="/password-reset/forgot-password" method="POST">
        @csrf
        <x-input label="Your email" type="email" name="email" placeholder="name@company.com" required="true" />
        @error("email")
        <x-message.error>
            {{ $message }}
        </x-message.error>
        @enderror

        <x-button type="submit">
            Send reset password link
        </x-button>
    </x-form>
</x-card.logo>
@endsection