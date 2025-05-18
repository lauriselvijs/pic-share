@props(['label', 'name'])

{{-- TODO:
[ ] - add strength meter for validation --}}

<div>
    <label for="{{ $name }}" class="block mb-2 text-base font-medium text-black">{{ $label }}</label>
    <input {{ $attributes->merge([
    'type' => 'text',
    'name' => $name,
    'id' => $name,
    'class' => 'bg-white border border-black text-black text-sm block w-full p-2.5',
    'placeholder' => false,
    'value' => '',
    'required' => false,
    'autocomplete' => false,
    'min' => false,
    'max' => false,
    ]) }}
    >
</div>
@error($name)
<x-message.error aria-describedby={{ $name }}>
    {{ $message }}
</x-message.error>
@enderror