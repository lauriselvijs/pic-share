@extends('layout.index')
@section('title')
Posts
@endsection

@section('content')
<div class='relative md:block flex justify-center transition-all'>
    @include('partials._hero')
    @include('partials._search')
</div>


<x-tag.filter :tagsCsv="app('request')->input('tag')" class='bg-sunset md:px-40 px-6 py-4' />

@unless (count($posts) == 0)
<div
    class='grid md:grid-cols-3 grid-cols-1 gap-0 md:gap-8 md:px-40 md:pt-12 md:pb-24 px-0 py-0 bg-sunset transition-all'>
    @foreach ($posts as $post)
    <x-card.post :post='$post' />
    @endforeach
</div>
<div class='bg-sunset sm:px-48 sm:pt-0 px-8 py-8'>
    {{-- What are links()? --}}
    {{ $posts->links() }}
</div>
@endunless
@endsection