<form wire:submit.prevent="save" x-data="{ showModal: false, showHelpModal: false }">
  @csrf
  <input type="hidden" name="status" wire:model.lazy="published">
  <x-hero class="is-primary">
    <div class="is-flex is-align-items-center" style="gap: 0.5rem;">
      <button @@click='showHelpModal = true' type="button" class="button is-primary">
        <x-lucide-help-circle class="icon" />
      </button>
      <div class="field has-addons" style="flex: 1">
        <div class="control is-expanded">
          <input placeholder="Post Title..." wire:model="title"
            x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor-changed')" type="text"
            class="input">
        </div>
        <div class="control">
          <button class="button is-dark">Save</button>
        </div>
        <div class="control">
          <button type="button" x-on:click="showModal = true; $wire.is_published = true"
            class="button is-light">Publish</button>
        </div>
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
  <div x-bind:class="{ 'is-active': showHelpModal }" class="modal">
    <div @@click="showHelpModal = false" class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Collection Editor</p>
        <button type="button" class="delete" @@click="showHelpModal = false"></button>
      </header>
      <section class="modal-card-body">
        This is the collection editor! Collections don't include posts right away, but you can add them later.
        To do this, check out the bookmark icon on the post you want to add to a collection, then click the
        plus to add it to a collection. In this view, you can write a short description, then save to begin adding
        items.
        Have Fun!
      </section>
    </div>
  </div>
</form>
</form>
