@extends("sections.layout")
@section("title")
Images
@endsection

@section("content")
<div>
    <div class="relative transition-all sm:block flex justify-center">
        @include("partials._hero")
        @include("partials._search")
    </div>

    @unless (count($images) == 0)
    <div
        class="grid md:grid-cols-3 grid-cols-1 gap-0 sm:gap-8 sm:pr-40 sm:pl-40 pr-0 pl-0 pt-0 pb-0 sm:pt-24 sm:pb-24 bg-sunset transition-all">
        @foreach ($images as $image)
        <x-card.image :image="$image" />
        @endforeach
    </div>
</div>
@endunless

@endsection