<div>
  <form wire:submit.prevent='save' x-data="{ show: false }"
    x-on:collection-created.document="history.replaceState(null, '', $event.detail.url)">
    <x-hero class="is-primary">
      <div class="is-flex is-align-items-center" style="gap: 0.5rem">
        <x-help title="Collection Editor">
          <p class="content has-text-black">
            This is the collection editor! Here you can write your collection and publish it to the world.
            The metadata accessed via the 'publish' or 'update metadata' button let's you set certain attributes
            about the collection that make it easier for people to find. Upon saving, you are able to add a post
            to the collection using the bookmark icon found on posts. Lastly, there is no autosave, so consider saving
            frequently.
          </p>
        </x-help>
        <div class="field has-addons" style="flex: 1">
          <div class="control is-expanded">
            <input class="input" type="text" placeholder="Collection Title..."
              wire:model.defer='post_collection.title'
              x-on:change="document.title = `ConneCTION - ${$el.value}`; $dispatch('editor-changed')">
          </div>
          <div class="control">
            <button class="button is-dark">Save</button>
          </div>
          <div class="control">
            @if ($this->post_collection->published)
              <button class="button" type="button" @@click="show = true;">
                Update Metadata
              </button>
            @else
              <button class="button" type="button"
                @@click="show = true; $wire.set('post_collection.published', true, true);">
                Publish
              </button>
            @endif
          </div>
        </div>
      </div>
    </x-hero>
    <main @if ($this->post_collection->exists) x-data="{tab: 0}" @endif class="container is-fluid mt-5">
      @if ($this->post_collection->exists)
        <section class="tabs is-centered">
          <ul>
            <li x-bind:class="{ 'is-active': tab == 0 }"><a x-on:click="tab = 0">Description</a></li>
            <li x-bind:class="{ 'is-active': tab == 1 }"><a x-on:click="tab = 1">Entries</a>
            </li>
          </ul>
        </section>
      @endif
      <section @if ($this->post_collection->exists) x-bind:class="{ 'is-hidden': tab !== 0 }" @endif>
        <x-editor name="body" wire:model.defer='body' />
      </section>
      @if ($this->post_collection->exists)
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
              @foreach ($this->post_collection->posts as $post)
                @livewire('collection.entry', ['post' => $post, 'post_collection' => $this->post_collection], key($post->id))
              @endforeach
            </tbody>
          </table>
        </section>
      @endif
    </main>
    <x-modal show-var="show" title="Set Collection Metadata">
      <div class="field">
        <div class="control">
          <x-forms.grades multiple wire:model.defer='grades' />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <x-forms.standards multiple wire:model.defer='standards' />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <x-forms.practices multiple wire:model.defer='practices' />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <x-forms.languages multiple wire:model.defer='languages' />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <x-forms.categories wire:model.defer='category' />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <x-forms.audiences wire:model.defer='audience' />
        </div>
      </div>
      <x-slot name="footer">
        <button class="button is-primary is-outlined" type="button"
          @if ($this->post_collection->published) @@click="show = false;" @else @@click="show = false; $wire.set('post_collection.published', false, true);" @endif>
          Cancel
        </button>
        <button class="button is-primary" type="submit" @@click="show = false">
          @if ($this->post_collection->published)
            Update Metadata
          @else
            Publish
          @endif
        </button>
      </x-slot>
    </x-modal>
  </form>
</div>
