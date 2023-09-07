@props(['name'])

<div class="flex items-start ">
    <div class="flex items-center h-5">
        <input {{ $attributes->merge([
        'id' => $name,
        'name' => $name,
        'type' => 'checkbox',
        'class' => 'w-4 h-4 border border-black rounded bg-white accent-black hover:cursor-pointer',
        'required' => false,
        ]) }}>
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $name }}" class="text-black hover:cursor-pointer">{{ $label }}</label>
    </div>
</div>