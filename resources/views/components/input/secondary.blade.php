@props(['label', 'type', 'name', 'id'])

<label for="{{ $name }}" hidden aria-labelledby="{{ $id }}">{{ $label }}</label>
<input {{ $attributes->merge([
'type' => $type,
'name' => $name,
'id' => $id,
'class' => 'bg-white flex-1 text-black text-base w-full h-full p-1 pl-8 pr-10',
'placeholder' => false,
'value' => '',
'required' => false
]) }}>