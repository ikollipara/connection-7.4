@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @routes
  @livewireStyles
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script defer src="{{ mix('js/app.js') }}"></script>
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body>
  <x-navbar />
  {{ $slot }}
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
    data-turbolinks-eval="false" data-turbo-eval="false"></script>
  <x-alert />
</body>

</html>
