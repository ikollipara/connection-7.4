<form wire:submit.prevent="save" x-data="{ showModal: false }" method="post">
  @csrf
  <input type="hidden" name="status" wire:model.lazy="published">
  <x-hero class="is-primary">
    <div class="field has-addons">
      <div class="control is-expanded">
        <input wire:model.lazy="title"
          x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor-changed')" type="text"
          class="input">
      </div>
      <div class="control">
        <button wire:loading.class="is-loading" class="button is-dark">Save</button>
      </div>
      <div class="control">
        @if (!$this->collection->published)
          <button type="button" x-on:click="showModal = true; $wire.published = true;"
            class="button is-light">Publish</button>
        @else
          <button type="button" x-on:click="showModal = true" class="button is-light">
            Update Metadata
          </button>
        @endif
      </div>
    </div>
  </x-hero>
  <main x-data="{ tab: 0 }" class="container is-fluid mt-5">
    <section class="tabs is-centered">
      <ul>
        <li x-bind:class="{ 'is-active': tab == 0 }"><a x-on:click="tab = 0">Description</a></li>
        <li x-bind:class="{ 'is-active': tab == 1 }"><a x-on:click="tab = 1">Entries</a></li>
      </ul>
    </section>
    <section x-bind:class="{ 'is-hidden': tab !== 0 }">
      <x-editor name="body" wire:model.lazy="body" />
    </section>
    <section class="is-hidden" x-bind:class="{ 'is-hidden': tab !== 1 }">
      <table class="table is-fullwidth">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Link</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($this->collection->posts as $post)
            <tr id="post-{{ $post->id }}">
              <td>{{ $post->title ?? 'Unamed Post' }}</td>
              <td>{{ $post->user->full_name() }}</td>
              <td><a href="{{ URL::route('posts.show', ['post' => $post]) }}">Visit</a></td>
              <td>
                <button wire:click="removeEntry('{{ $post->id }}')" type="button" class="delete"></button>
                <script>
                  document.addEventListener('livewire:load', function() {
                    Livewire.on('postRemoved', postId => {
                      document.getElementById(`post-${postId}`).remove()
                    })
                  })
                </script>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </main>
  <section class="modal" x-bind:class="{ 'is-active': showModal }">
    <div class="modal-background"></div>
    <article class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Set Collection Metadata</p>
        <button type="button" x-on:click="showModal = false" class="delete"></button>
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
        @if (!$this->collection->published)
          <button type="button" x-on:click="showModal = false; $wire.published = false;"
            class="button is-primary is-outlined">
            Cancel
          </button>
          <button @@click="showModal = false" class="button is-primary">Publish</button>
        @else
          <button type="button" x-on:click="showModal = false" class="button is-primary is-outlined">
            Cancel
          </button>
          <button type="submit" x-on:click="showModal = false" class="button is-primary">Update</button>
        @endif
      </footer>
    </article>
  </section>
</form>
