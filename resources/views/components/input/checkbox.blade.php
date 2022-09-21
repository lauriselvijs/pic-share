@props(['name', 'required' ])

<div class='flex items-start'>
    <div class='flex items-center h-5'>
        <input id={{ $name }} name={{ $name }} aria-describedby={{ $name }} type='checkbox'
            class='w-4 h-4 border border-black rounded bg-white accent-black' {!! $required ? "required='required'" : ''
            !!}>
    </div>
    <div class='ml-3 text-sm'>
        <label for={{ $name }} class='text-black'>{{ $checkboxLabel }}</label>
    </div>
</div>