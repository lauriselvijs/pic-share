@extends('layout.index')
@section('title')
Add Image
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        Add new image
    </x-slot>
    <x-form.post action='/images' />
</x-card.logo>

@endsection