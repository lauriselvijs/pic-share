@extends("layout.index")
@section("title")
{{ $image->title }}
@endsection
@section("content")

<div class="flex flex-col gap-2 md:px-40 pt-0 pb-24 bg-shadow text-white text-left">
    <img class="h-auto w-full md:scale-75 scale-100" src={{ asset($image->image) }} alt="User image">
    <div class="px-6">
        <h2 class="text-2xl font-bold py-4 leading-snug">
            {{ $image->title }}
        </h2>

        <x-tag :tagsCsv="$image->tags" />
        <p class="text-base font-bold py-4">
            {{ $image->author }}
        </p>
        <div class="flex md:justify-between md:flex-row flex-col md:gap-8 gap-8 pt-8">
            @auth
            @if (auth()->user()->name == $image->author)
            <div class="flex gap-8">
                <a href="/images/{{ $image->id }}/edit">
                    <x-button.tertiary type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                            <path
                                d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z" />
                        </svg>
                        Edit
                    </x-button.tertiary>
                </a>
                <form action="/images/{{ $image->id }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <x-button.tertiary type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                            <path
                                d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z" />
                        </svg>
                        Delete
                    </x-button.tertiary>
                </form>
            </div>
            @endif
            @endauth
            <a href="/">
                <x-button.tertiary type="button">
                    <svg aria-hidden="true" class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Back
                </x-button.tertiary>
            </a>
        </div>
    </div>

</div>

@endsection