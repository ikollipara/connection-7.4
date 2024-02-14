<div class="navbar-item">
  <div x-data="{ text: '', show: false, saved: false }" x-on:editor-changed.window="text = 'Unsaved Changes'; show = true; saved = false"
    x-on:editor-saved.window="text = 'Changes Saved'; show = true; saved = true; setTimeout(() => { show = false }, 300)"
    x-bind:class="{ 'is-hidden': !show, 'is-danger': !saved, 'is-success': saved }" x-text="text"
    class="notification pt-1 pb-1"></div>
</div>
