@extends('layout.index')
@section('title')
Edit Post
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        Edit post info
    </x-slot>
    <x-form.post :action="route('posts.edit', $post->id)" :post='$post' />
</x-card.logo>

@endsection