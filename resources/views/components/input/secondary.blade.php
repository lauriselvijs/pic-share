@props(['label', 'type', 'name', 'placeholder', 'required', 'value', 'id'])


<label for={{ $name }} hidden aria-labelledby={{ $id }}>{{ $label }}</label>
<input type={{ $type }} name={{ $name }} id={{ $id }}
    class='bg-white flex-1 text-black text-base w-full h-full p-1 pl-8 pr-10' placeholder='{{ $placeholder }}'
    value='{{ $value }}'>