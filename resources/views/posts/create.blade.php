@extends('layout.index')
@section('title')
Add Post
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        Add new post
    </x-slot>
    <x-form.post action='/posts' />
</x-card.logo>

@endsection