@props(['showVar', 'title', 'footer' => null])

<section class="modal" x-bind:class="{ 'is-active': {{ $showVar }} }">
  <div class="modal-background" @@click="{{ $showVar }} = false"></div>
  <article class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{ $title }}</p>
      <button @@click="{{ $showVar }} = false" type="button" class="delete"></button>
    </header>
    <section class="modal-card-body">
      {{ $slot }}
    </section>
    <footer class="modal-card-foot">
      {{ $footer }}
    </footer>
  </article>
</section>
