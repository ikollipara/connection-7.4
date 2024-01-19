<form wire:submit.prevent="save" x-data="{ showModal: false }">
  @csrf
  <input type="hidden" name="status" wire:model.lazy="published">
  <x-hero class="is-primary">
    <div class="field has-addons">
      <div class="control is-expanded">
        <input wire:model.lazy="title"
          @@change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor-changed')"
          placeholder="Collection Title..." type="text" class="input">
      </div>
      <div class="control">
        <button type="submit" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <button type="button" @@click="showModal = true; $wire.published = true"
          class="button is-light">Publish</button>
      </div>
    </div>
  </x-hero>
  <main class="container is-fluid mt-5">
    <x-editor name="body" wire:model.lazy="body" />
  </main>
  <section class="modal" ::class="{ 'is-active': showModal }">
    <div class="modal-background"></div>
    <article class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Set Collection Metadata</p>
        <button type="button" @@click="showModal = false" class="delete"></button>
      </header>
      <section class="modal-card-body">
        <div class="field">
          <div class="control">
            <x-forms.grades multiple wire:model.lazy="grades" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.standards multiple wire:model.lazy="standards" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.practices multiple wire:model.lazy="practices" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.categories wire:model.lazy="category" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <x-forms.audiences wire:model.lazy="audience" />
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button type="button" @@click="showModal = false; $wire.published = false"
          class="button is-primary is-outlined">
          Cancel
        </button>
        <button type="submit" @@click="showModal = false" wire:loading.class='is-loading'
          class="button is-primary">Publish</button>
      </footer>
    </article>
  </section>
</form>
