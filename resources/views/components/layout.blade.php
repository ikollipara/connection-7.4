<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @routes
    @livewireStyles
    <script src="/js/app.js" defer></script>
    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
    @stack('scripts')
    <title>{{ $title ?? 'Laravel' }}</title>
</head>

<body>
    <x-navbar></x-navbar>
    {{ $slot }}
    @livewireScripts
    <x-alert />
</body>

</html>
