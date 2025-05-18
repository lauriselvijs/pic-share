<div {{ $attributes->merge([
    'class' => 'text-small p-2 text-error font-bold bg-sunset rounded-lg',
    'aria-describedby' => false
    ]) }} role='alert'>
    {{ $slot }}
</div>