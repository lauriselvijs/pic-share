@extends('layout.index')
@section('title')
{{ $post->title }}
@endsection
@section('content')

<div class='flex flex-col gap-2 md:px-40 pt-0 pb-24 bg-shadow text-white text-left'>
    <img class='h-auto w-full md:scale-75 scale-100' src={{ asset($post->image) }} alt='User posted image'>
    <div class='px-6 flex flex-col justify-center items-center  sm:block text-center sm:text-left'>
        <h2 class='text-2xl font-bold py-4 leading-snug sm:text-left'>
            {{ $post->title }}
        </h2>

        <x-tag :tagsCsv='$post->tags' />
        <p class='text-base font-bold py-4 '>
            {{ $post->author }}
        </p>
        <h2 class='text-2xl font-bold py-4 tracking-wide'>
            ${{ $post->price }}
        </h2>
        <div class='flex sm:justify-between justify-center flex-wrap md:gap-8 gap-8 pt-8'>
            {{--
            TODO:
            [ ] - replace with one payment button --}}
            @can('buy', $post)
            <a href={{ route('payment.charge', [$post->id])}}>
                <x-button.tertiary type='submit'>
                    <svg xmlns="http://www.w3.org/2000/svg" width='16' height='16' viewBox="0 0 576 512">
                        <path
                            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                    </svg>
                    Buy
                </x-button.tertiary>
            </a>
            @endcan

            @guest
            <a href={{ route('payment.charge', [$post->id])}}>
                <x-button.tertiary type='submit'>
                    <svg xmlns="http://www.w3.org/2000/svg" width='16' height='16' viewBox="0 0 576 512">
                        <path
                            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                    </svg>
                    Buy
                </x-button.tertiary>
            </a>
            @endguest



            @auth
            <div class='flex gap-8'>
                @can('update', $post)
                <a href={{ route('posts.edit', $post->id) }}>
                    <x-button.tertiary type='button'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'>
                            <path
                                d='M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z' />
                        </svg>
                        Edit
                    </x-button.tertiary>
                </a>
                @endcan
                @can('delete', $post)
                <form action={{ route('posts.destroy', $post->id) }} method='POST'>
                    @csrf
                    @method('DELETE')
                    <x-button.tertiary type='submit'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'>
                            <path
                                d='M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z' />
                        </svg>
                        Delete
                    </x-button.tertiary>
                </form>
                @endcan
            </div>
            @endauth
            <a href={{ route('posts.index') }}>
                <x-button.tertiary type='button'>
                    <svg class='mr-2 w-5 h-5' fill='currentColor' xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512">
                        <path
                            d="M109.3 288L480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 73.4-73.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288z" />
                    </svg>
                    Back
                </x-button.tertiary>
            </a>
        </div>
    </div>

</div>

@endsection