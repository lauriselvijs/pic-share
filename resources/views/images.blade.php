@extends("layout")

@section("content")
@unless (count($images) ==0)
<div class="grid md:grid-cols-3 sm:grid-cols-1 gap-y-8 justify-items-center		 pr-48 pl-48 pt-24 pb-24 bg-sunset ">
    @foreach ($images as $image)
    <div class="flex flex-col gap-2 w-80 rounded  bg-shadow text-white text-left hover:scale-105">
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