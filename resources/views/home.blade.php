@extends('layout.index')

@section('title')
Login
@endsection

@section('content')

<x-card.logo>
    <x-slot name='heading'>
    </x-slot>
    <div class='flex flex-col gap-4'>
        <a href={{ route('posts.index')}}>
            <x-button type='button'>
                View posts
            </x-button>
        </a>

        <a href={{ route('auth.create')}}>
            <x-button type='button'>
                Sign up
            </x-button>
        </a>
    </div>
</x-card.logo>
@endsection