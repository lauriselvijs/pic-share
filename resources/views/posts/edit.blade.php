@extends('layout.index')
@section('title')
{{ __('Edit Post') }}
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        {{ __('Edit post info') }}
    </x-slot>
    <x-form.post :action="route('posts.update', $post->slug)" :post='$post' />
</x-card.logo>

@endsection