@extends('layout.index')
@section('title')
Edit Image
@endsection

@section('content')
<x-card.logo>
    <x-slot name='heading'>
        Edit image info
    </x-slot>
    <x-form.post action='/images/{{ $image->id }}' :image='$image' />
</x-card.logo>

@endsection