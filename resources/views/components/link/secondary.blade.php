@props(['href'])


<a href='{{ $href }}' {{ $attributes->merge(['class' => 'text-white hover:underline']) }}>{{$slot}}</a>