@props(['action', 'method', 'enctype' => ''])

<form method={{ $method }} class='space-y-4' action={{ $action }} enctype={{ $enctype }}>
    {{ $slot }}
</form>