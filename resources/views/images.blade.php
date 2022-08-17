@extends("layout")

@section("content")
@unless (count($images) ==0)
<div
    class="grid md:grid-cols-3 grid-cols-1 gap-0 sm:gap-8 sm:pr-48 sm:pl-48 pr-0 pl-0 pt-0 pb-0 sm:pt-24 sm:pb-24 bg-sunset transition-all">
    @foreach ($images as $image)
    <div class="flex flex-col gap-2 rounded bg-shadow text-white text-left hover:scale-100 sm:hover:scale-105">
        <img class="h-full w-full" src={{ asset("images/forest.jpg") }} alt="Forest">
        <h2 class="text-2xl font-bold p-4 hover:text-sunset leading-snug">
            <a href="/images/{{ $image->id }}"> {{ $image->title }}
            </a>
        </h2>
        <p class="text-base font-bold p-4">
            {{ $image->author }}
        </p>
    </div>
    @endforeach
</div>

@else
<p>No images found</p>
@endunless

@endsection