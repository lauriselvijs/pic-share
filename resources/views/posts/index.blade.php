@extends('layout.index')
@section('title')
{{ __('Posts') }}
@endsection

@section('content')
<div class='relative md:block flex justify-center transition-all'>
    @include('partials._hero')
    @include('partials._search')
</div>

@unless (count($posts) == 0)
<div
    class='grid md:grid-cols-3 grid-cols-1 gap-0 md:gap-8 md:px-40 md:pt-12 md:pb-24 px-0 py-0 bg-sunset transition-all'>
    @foreach ($posts as $post)
    <x-card.post :post='$post' />
    @endforeach
</div>
<div class='bg-sunset sm:px-48 sm:py-4 px-8 py-8'>
    {{ $posts->links() }}
</div>
@endunless
@endsection