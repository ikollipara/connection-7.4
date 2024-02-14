@props(['route', 'isButton' => false])
@if ($isButton)
  <li class="navbar-item">
    <a {{ $attributes->merge(['class' => 'button is-primary']) }} href="{{ $route }}">
      {{ $slot }}
    </a>
  </li>
@else
  <a {{ $attributes->merge(['class' => 'navbar-item']) }} href="{{ $route }}">
    {{ $slot }}
  </a>
@endif
