<form @@keyup.ctrl.s.stop.prevent.capture="$wire.save" wire:submit.prevent="save" x-data="{ showModal: false }"
  method="post">
  @csrf
  <input type="hidden" name="status" wire:model.defer="is_published">
  <x-hero class="is-primary">
    <div class="field has-addons">
      <div class="control is-expanded">
        <input wire:model.defer="title"
          x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor-changed')" type="text"
          class="input">
      </div>
      <div class="control">
        <button wire:loading.class="is-loading" class="button is-dark">Save</button>
      </div>
      <div class="control">
        @if (!$this->post->published)
          <button type="button" x-on:click="showModal = true; $wire.is_published = true;"
            class="button is-light">Publish</button>
        @else
          <button type="button" x-on:click="showModal = true" class="button is-light">
            Update Metadata
          </button>
        @endif
      </div>
    </div>
  </x-hero>
  <main class="container is-fluid mt-5">
    <x-editor name="body" wire:model.defer="body" />
  </main>
  <section class="modal" x-bind:class="{ 'is-active': showModal }">
    <div class="modal-background"></div>
    <article class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Set Post Metadata</p>
        <button type="button" x-on:click="showModal = false" class="delete"></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <div class="control">
            <x-forms.grades multiple wire:model.defer="grades" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.standards multiple wire:model.defer="standards" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.practices multiple wire:model.defer="practices" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.categories wire:model.defer="category" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.audiences wire:model.defer="audience" />
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        @if (!$this->post->is_published)
          <button type="button" x-on:click="showModal = false; $wire.is_published = false;"
            class="button is-primary is-outlined">
            Cancel
          </button>
          <button x-on:click='showModal = false' wire:loading.class='is-loading'
            class="button is-primary">Publish</button>
        @else
          <button type="button" x-on:click="showModal = false" class="button is-primary is-outlined">
            Cancel
          </button>
          <button wire:loading.class='is-loading' x-on:click="showModal = false"
            class="button is-primary">Update</button>
        @endif
      </footer>
    </article>
  </section>
</form>
