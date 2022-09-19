@props(['href'])

<a href={{ $href }} {{ $attributes->merge(['class' => 'text-black hover:underline'])
    }}>{{$slot}}</a>