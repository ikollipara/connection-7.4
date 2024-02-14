@props(['title', 'icon' => false])

<div class="navbar-item has-dropdown is-hoverable">
  <a class="navbar-link mt-2 mb-2 icon-text">
    @if ($icon)
      <span class="icon">
        {{ $icon }}
      </span>
    @endif
    <span>{{ $title }}</span>
  </a>
  <div class="navbar-dropdown">
    {{ $slot }}
  </div>
</div>
