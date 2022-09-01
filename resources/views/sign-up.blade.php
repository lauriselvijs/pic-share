@extends("sections.layout")

@section("title")
Sign Up
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Create an account
    </x-slot>
    <x-form.auth>
        <x-slot name="extraInputFields">
            <x-input label="Confirm password" type="confirm-password" name="confirm-password" placeholder="••••••••"
                required="" />
        </x-slot>
        <x-slot name="addAuthFormInfo">
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox"
                            class="w-4 h-4 border border-black rounded bg-white accent-black">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="text-black">By signing up, you are creating a PicShare account, and
                            you
                            agree to PicShare <x-link class="font-bold" href="/terms-of-use">Terms
                                of
                                Use</x-link> and <x-link class="font-bold" href="/privacy-policy">
                                Privacy
                                Policy</x-link>.</label>
                    </div>
                </div>
            </div>
        </x-slot>
        <button type="submit"
            class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Sign
            in</button>
        <x-slot name="authFormFooter">
            Already have an account? <x-link href="/login" class="font-medium">Sign
                in here</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection