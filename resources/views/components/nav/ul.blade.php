@props(["hoverLinkColor"])

<ul {{ $attributes->merge(["class" => "md:flex gap-8 justify-between items-center whitespace-nowrap"]) }}>
    @auth
    <li class="cursor-pointer hover:{{ $hoverLinkColor }}"><a href="/images/create">Add new image</a></li>
    <li class="cursor-pointer hover:{{ $hoverLinkColor }}"><a href="/images/my-images">My images</a></li>
    {{ $addListItem }}
    <li class="cursor-pointer hover:{{ $hoverLinkColor }}">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="flex justify-center items-center gap-4">
                Log out
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>
        </form>
    </li>
    @else
    <li class="cursor-pointer hover:{{ $hoverLinkColor }}"><a href="/sign-up">Sign up</a></li>
    <li class="cursor-pointer hover:{{ $hoverLinkColor }}"><a href="/login">Login</a></li>
    @endauth
</ul>