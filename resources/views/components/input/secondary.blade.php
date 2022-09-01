@props(["label", "type", "name", "placeholder", "required" ])

<label for={{ $name }} class="sr-only">{{ $label }}</label>
<input type={{ $type }} name={{ $name }} id={{ $name }}
    class="bg-white flex-1 text-black text-base w-full h-full p-1 pl-8 pr-10 ml-6 sm:ml-40"
    placeholder="{{ $placeholder }}">