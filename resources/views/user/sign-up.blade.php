@extends("layout.index")

@section("title")
Sign Up
@endsection

@section("content")
<x-card.logo>
    <x-slot name="heading">
        Create an account
    </x-slot>
    <x-form.auth confirmPassword="false" action="/sign-up">
        <x-slot name="extraInputFields">
            <x-input label="Your name" type="text" name="name" placeholder="John Doe" required="required"
                value="{{ old('name') }}" />
            @error("name")
            <x-message.error>
                {{ $message }}
            </x-message.error>
            @enderror
        </x-slot>
        <x-slot name="addAuthFormInfo">
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox" name="agreement"
                            class="w-4 h-4 border border-black rounded bg-white accent-black" required="required" {{
                            old('agreement')=='on' ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="text-black">By signing up, you are creating a PicShare account, and
                            you
                            agree to PicShare <x-link class="font-bold" href="/terms-of-use">Terms
                                of
                                Use</x-link> and <x-link class="font-bold" href="/privacy-policy">
                                Privacy
                                Policy</x-link>.<span class='text-error'>*</span></label>
                    </div>
                </div>
            </div>
            @error("agreement")
            <x-message.error>
                {{ $message }}
            </x-message.error>
            @enderror
        </x-slot>
        <x-slot name="submit">
            <x-button type="submit">
                Sign up
            </x-button>
        </x-slot>
        <x-slot name="authFormFooter">
            Already have an account? <x-link href="/login" class="font-medium">Sign
                in here</x-link>
        </x-slot>
    </x-form.auth>
</x-card.logo>
@endsection