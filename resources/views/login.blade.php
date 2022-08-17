@extends("layout")

@section("content")
<div class="bg-sunset">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
        <a href="/" class="flex items-center mb-6 text-2xl font-bold text-black">
            <img class="w-8 h-8 mr-2" src={{ asset("images/logo.png") }} alt="logo">
            PicShare
        </a>
        <div class="w-full bg-white shadow  sm:max-w-md">
            <div class="p-6 space-y-4 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form class="space-y-4" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-base font-medium text-black">Your
                            email</label>
                        <input type="email" name="email" id="email"
                            class="bg-white border border-black text-black text-sm block w-full p-2.5"
                            placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-base font-medium text-black ">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-white border border-black text-black text-base block w-full p-2.5" required="">
                    </div>
                    <div class="flex justify-evenly items-center">
                        <hr class="bg-black w-full opacity-20" />
                        <span class="text-base font-light text-black px-4">or</span>
                        <hr class="bg-black w-full opacity-20" />
                    </div>
                    <a href="/" class="pl-2.5">
                        <button type="button"
                            class="py-2.5 flex justify-center gap-4 items-center border border-solid	border-black w-full bg-white text-black hover:bg-sunset focus:ring-4 focus:outline-none focus:ring-shadow font-medium text-base">
                            <img src={{ asset("images/google-icon.svg") }} alt="Google login" class="w-6 h-6">
                            Sign in with Google
                        </button>
                    </a>
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
                        <a href="#" class="text-sm font-medium text-black hover:underline">Forgot
                            password?</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-black hover:bg-shadow focus:ring-4 focus:outline-none focus:ring-sunset font-medium text-base px-5 py-2.5 text-center">Sign
                        in</button>
                    <p class="text-sm font-light text-black">
                        Don’t have an account yet? <a href="/sign-up"
                            class="font-medium text-black hover:underline">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection