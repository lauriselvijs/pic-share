@props(['action', 'confirmPassword' => false])

<form method='POST' action="{{ $action }}" class='space-y-4'>
    @csrf
    {{ $extraInputFields }}
    <x-input label="{{ __(' Your email') }}" type='email' name='email' placeholder="{{ __(' name@company.com') }}"
        required='true' value="{{ old('email') }}" />
    @error("email")
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    <x-input label="{{ __(' Password') }}" type='password' name='password' placeholder='••••••••' required='true' />
    @error('password')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror

    @if ($confirmPassword)
    <x-input label="{{ __(' Confirm password') }}" type='password' name='password_confirmation' placeholder='••••••••'
        required='required' />
    @error('password_confirmation')
    <x-message.error>
        {{ $message }}
    </x-message.error>
    @enderror
    @endif

    <div class='flex justify-evenly items-center'>
        <hr class='bg-black w-full opacity-20' />
        <span class='text-base font-light text-black px-4'>{{ __('or') }}</span>
        <hr class='bg-black w-full opacity-20' />
    </div>
    @include('partials.button._google-auth')
    {{ $addAuthFormInfo }}
    {{ $submit }}
    <p class='text-sm font-light text-black'>
        {{ $authFormFooter }}
    </p>
</form>