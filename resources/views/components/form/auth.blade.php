@props(["action"])

<x-form method="POST" action={{ $action }}>
    @csrf
    <x-input label="Your email" type="email" name="email" placeholder="name@company.com" required="true" />
    <x-input label="Password" type="password" name="password" placeholder="••••••••" required="true" />
    {{ $extraInputFields }}
    <div class="flex justify-evenly items-center">
        <hr class="bg-black w-full opacity-20" />
        <span class="text-base font-light text-black px-4">or</span>
        <hr class="bg-black w-full opacity-20" />
    </div>
    @include("partials.button._google-auth")
    {{ $addAuthFormInfo }}
    {{ $submit }}
    <p class="text-sm font-light text-black">
        {{ $authFormFooter }}
    </p>
</x-form>