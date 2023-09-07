@props(['action', 'confirmPassword' => false])

<form method='POST' action="{{ $action }}" class='space-y-4'>
    @csrf
    {{ $fields }}
    <x-input label="{{ __(' Your email') }}" type='email' name='email' autocomplete="email"
        placeholder="{{ __(' name@company.com') }}" required value="{{ old('email') }}" />

    <x-input label="{{ __('Password') }}" type="password" name="password"
        autocomplete="{{ $confirmPassword ? 'new-password' : 'current-password' }}" placeholder="••••••••" required />

    @if ($confirmPassword)
    <x-input label="{{ __(' Confirm password') }}" type='password' name='password_confirmation'
        autocomplete="new-password" placeholder='••••••••' required />
    @endif

    <div class='flex justify-evenly items-center'>
        <hr class='bg-black w-full opacity-20' />
        <span class='text-base font-light text-black px-4'>{{ __('or') }}</span>
        <hr class='bg-black w-full opacity-20' />
    </div>
    @include('partials.button._google-auth')
    {{ $info }}
    {{ $submit }}
    <p class='text-sm font-light text-black'>
        {{ $footer }}
    </p>
</form>