<li class="navbar-item">
  <figure class="image is-32x32">
    <img @@avatar-updated.document="$el.src = $event.detail.url" src="{{ auth()->user()->avatar() }}"
      alt="">
  </figure>
</li>
