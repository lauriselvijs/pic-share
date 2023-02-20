@extends('layout.index')
@section('title')
Payment
@endsection
@section('content')

<div class='flex flex-1 flex-col justify-center items-center bg-shadow p-8'>
    <form action="{{route('payment.process', [$post->id])}}" method='POST' id='payment-form'
        class='flex flex-col gap-4 p-4 w-3/4 md:w-1/4 shadow-lg shadow-black bg-sunset backdrop-blur-md'>
        @csrf
        <h2 class='text-2xl font-bold uppercase text-error'>Only for Testing!</h2>
        <div class='flex flex-col'>
            <div class='text-base font-bold'>Payment amount</div>
            <div class='plan-price text-2xl font-bold text-shadow'>${{$post->price}}</div>
        </div>
        <div class='flex flex-col'>
            <label class='text-base font-bold' for='card-holder-name'>Card Holder Name</label>
            <input class='bg-sunset text-shadow uppercase' id='card-holder-name' type='text' value='{{$user->name}}'>
        </div>
        <div class='form-row text-base'>
            <label class='font-bold' for='card-element'>Credit or debit card</label>
            <div id='card-element-container' class='pt-2'> </div>
            <!-- Used to display form errors. -->
            <div class='pt-4'>
                <div id='card-errors' class='text-error' role='alert'></div>
                @if (count($errors) > 0)
                <div class='text-base text-error pt-4'>
                    @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class='flex justify-center'>
            {{--
            TODO:
            [ ] - replace with primary btn --}}
            <button
                class='flex justify-center w-full text-white bg-black hover:bg-shadow focus:outline
                focus:outline-4
                focus:outline-white font-medium text-base px-5 py-2.5 text-center active:bg-black disabled:hover:bg-black disabled:opacity-20'
                type='button' id='card-button'>
                <svg id='pay-btn-spinner' class='fill-sunset animate-spin hidden' xmlns='http://www.w3.org/2000/svg'
                    width='32' height='32' viewBox='0 0 512 512'>
                    <path
                        d='M304 48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zm0 416c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM48 304c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48zm464-48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM142.9 437c18.7-18.7 18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zm0-294.2c18.7-18.7 18.7-49.1 0-67.9S93.7 56.2 75 75s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zM369.1 437c18.7 18.7 49.1 18.7 67.9 0s18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9z' />
                </svg>
                <span id='pay-btn-text'>Pay ${{$post->price}}</span>
            </button>
        </div>
    </form>
</div>
@endsection