@extends("layout.index")

@section("title")
Login
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Login to your account
    </x-slot>
    <x-form.auth action="/users/authenticate">
        <x-slot name="extraInputFields">
        </x-slot>
        <x-slot name="addAuthFormInfo">
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" name="remember" aria-describedby="remember" type="checkbox"
                            class="w-4 h-4 border border-black rounded bg-white accent-black">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="text-black">Remember me</label>
                    </div>
                </div>
                <x-link href="#" class="text-sm font-medium text-black hover:underline">Forgot
                    password?</x-link>
            </div>
        </x-slot>
        <x-slot name="submit">
            <x-button type="submit">
                Login
            </x-button>
        </x-slot>
        <x-slot name="authFormFooter">
            Don’t have an account yet? <x-link href="/sign-up" class="font-medium text-black hover:underline">
                Sign
                up</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection