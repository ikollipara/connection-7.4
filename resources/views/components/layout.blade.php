@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @routes
  @livewireStyles
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body>
  <x-navbar />
  {{ $slot }}
  @livewireScripts
  <script defer src="{{ mix('js/app.js') }}"></script>
  <x-alert />
</body>

</html>
