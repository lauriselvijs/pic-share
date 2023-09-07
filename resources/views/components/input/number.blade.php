@props([
'label',
'name',
])

<div>
    <label for="{{ $name }}" class="block mb-2 text-base font-medium text-black">{{ $label }}</label>
    <input {{ $attributes->merge([
    'step' => '.01',
    'min' => '0.01',
    'max' => '199999.99',
    'name' => $name,
    'id' => $name,
    'class' => 'bg-white border border-black text-black text-sm block w-full p-2.5',
    'placeholder' => false,
    'value' => false,
    'required' => false
    ])
    }} type="number">
</div>
@error($name)
<x-message.error>
    {{ $message }}
</x-message.error>
@enderror