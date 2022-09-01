@props(["action"])

<form class="space-y-4" action={{ $action }}>
    {{ $slot }}
</form>