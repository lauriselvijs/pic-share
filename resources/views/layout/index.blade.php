<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <title>PicShare - @yield('title')</title>
</head>

<body class="min-h-screen flex flex-col">
    @include('partials._header')
    <main class='relative flex-1 flex flex-col'>
        <x-message.flash />
        @yield('content')
    </main>
    @include('partials._footer')
</body>

</html>