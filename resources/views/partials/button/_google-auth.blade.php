<a href={{ route('auth.google_redirect') }} class='pl-2.5'>
    <x-button.secondary type='button'>
        <img role="img" src={{ asset('assets/icons/google-icon.svg') }} alt='Google login' class='w-6 h-6'>
        {{ __('Login with Google') }}
    </x-button.secondary>
</a>