@props(['hoverLinkColor'])

<ul {{ $attributes->merge(['class' => 'md:flex md:flex-row md:pr-0 md:gap-8 flex flex-col pr-8 gap-4 justify-between
    items-start
    whitespace-nowrap'])
    }}>
    @auth
    <a href={{ route('posts.create') }} class='cursor-pointer hover:{{ $hoverLinkColor }}'>
        <li>Add new post</li>
    </a>
    <li class='cursor-pointer hover:{{ $hoverLinkColor }}'>
        <form method='GET' action={{ route('users.posts', auth()->id()) }}>
            @csrf
            <button type='submit'>My Posts</button>
        </form>
    </li>
    {{ $addListItem }}
    <li class='cursor-pointer hover:{{ $hoverLinkColor }}'>
        <form method='POST' action={{ route('auth.logout')}}>
            @csrf
            <button type='submit' class='flex justify-center items-center gap-4'>
                Log out
                <svg class='w-6 h-6' fill='currentColor' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path
                        d="M534.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L434.7 224 224 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM192 96c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-53 0-96 43-96 96l0 256c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z" />
                </svg>
            </button>
        </form>
    </li>
    @else
    <li class='cursor-pointer hover:{{ $hoverLinkColor }}'><a href={{ route('auth.create') }}>Sign up</a></li>
    <li class='cursor-pointer hover:{{ $hoverLinkColor }}'><a href={{ route('auth.login') }}>Login</a></li>
    @endauth
</ul>