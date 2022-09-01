@props(["action", "method"])

<form method={{ $method }} class="space-y-4" action={{ $action }}>
    {{ $slot }}
</form>