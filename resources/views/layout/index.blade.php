<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>PicShare - @yield('title')</title>
</head>

<body class="min-h-screen w-fit flex flex-col">
    @include('partials._header')
    <main class='relative flex-1 flex flex-col'>
        <x-message.flash />
        @yield('content')
    </main>
    @include('partials._footer')
</body>

</html>