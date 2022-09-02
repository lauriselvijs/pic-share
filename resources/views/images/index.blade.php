@extends("layout.index")
@section("title")
Images
@endsection

@section("content")
<div class="relative transition-all sm:block flex justify-center">
    @include("partials._hero")
    @include("partials._search")
</div>

@unless (count($images) == 0)
<div
    class="grid md:grid-cols-3 grid-cols-1 gap-0 sm:gap-8 sm:px-40 px-0 py-0 sm:pt-24 sm:pb-24 bg-sunset transition-all">
    @foreach ($images as $image)
    <x-card.image :image="$image" />
    @endforeach

</div>
<div class="bg-sunset sm:px-48 sm:pt-0 px-8 py-8">
    {{ $images->links() }}
</div>
@endunless
@endsection