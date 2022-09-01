@extends("layout")

@section("title")
Login
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Sign in to your account
    </x-slot>
    <x-auth.form>
        <x-slot name="extraInputFields">
        </x-slot>
        <x-slot name="addAuthFormInfo">
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox"
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
        <button type="submit"
            class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Sign
            in</button>
        <x-slot name="authFormFooter">
            Don’t have an account yet? <x-link href="/sign-up" class="font-medium text-black hover:underline">
                Sign
                up</x-link>
        </x-slot>
    </x-auth.form>
</x-card.logo>
@endsection