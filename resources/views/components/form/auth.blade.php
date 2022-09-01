@props(["action"])
<x-form action={{ $action }}>
    <x-input label="Your email" type="email" name="email" placeholder="name@company.com" required="true" />
    <x-input label="Password" type="password" name="password" placeholder="••••••••" required="true" />
    {{ $extraInputFields }}
    <div class="flex justify-evenly items-center">
        <hr class="bg-black w-full opacity-20" />
        <span class="text-base font-light text-black px-4">or</span>
        <hr class="bg-black w-full opacity-20" />
    </div>
    <a href="/" class="pl-2.5">
        {{-- TODO:
        [] - create prim btn comp --}}
        <button type="button"
            class="py-2.5 flex justify-center gap-4 items-center border border-solid	border-black w-full bg-white text-black hover:bg-sunset focus:ring-4 focus:outline-none focus:ring-shadow font-medium text-base">
            <img src={{ asset("images/google-icon.svg") }} alt="Google login" class="w-6 h-6">
            Sign in with Google
        </button>
    </a>
    {{ $addAuthFormInfo }}
    {{-- TODO:
    [] - create sec btn comp --}}
    <button type="submit"
        class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Sign
        in</button>
    <p class="text-sm font-light text-black">
        {{ $authFormFooter }}
    </p>
</x-form>