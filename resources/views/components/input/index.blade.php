@props(['label', 'type', 'name', 'placeholder', 'required' => false, 'value' => '', 'step' => '.01', 'min' => '0.01',
'max' => '199999.99'])

<div>
    <label for={{ $name }} class='block mb-2 text-base font-medium text-black'>{{ $label }}</label>
    <input type={{ $type }} step={{ $step }} min={{ $min }} max={{ $max }} name={{ $name }} id={{ $name }}
        class='bg-white border border-black text-black text-sm block w-full p-2.5' placeholder='{{ $placeholder }}' {!!
        $required ? 'required' : '' !!} value="{{ $value }}">
</div>