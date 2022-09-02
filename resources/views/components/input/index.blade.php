@props(["label", "type", "name", "placeholder", "required", "value" => "" ])

<div>
    <label for={{ $name }} class="block mb-2 text-base font-medium text-black">{{ $label }}</label>
    <input type={{ $type }} name={{ $name }} id={{ $name }}
        class="bg-white border border-black text-black text-sm block w-full p-2.5" placeholder="{{ $placeholder }}" {!!
        $required ? "required='required'" : "" !!} value={{ $value }}>
</div>