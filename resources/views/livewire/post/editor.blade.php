<div>
  <form wire:submit.prevent='save' x-data="{ show: false }"
    x-on:post-created.document="history.replaceState(null, '', $event.detail.url)">
    <x-hero class="is-primary">
      <div class="is-flex is-align-items-center" style="gap: 0.5rem;">
        <x-help title="Post Editor">
          <p class="content has-text-black">
            This is the post editor! Here you can write your post and publish it to the world.
            The metadata accessed via the 'publish' or 'update metadata' button let's you set
            certain attributes about the post that make it easier for people to find. Lastly,
            there is no autosave, so consider saving frequently.
          </p>
        </x-help>
        <div class="field has-addons" style="flex: 1">
          <div class="control is-expanded">
            <input class="input" type="text" placeholder="Post Title..." wire:model.lazy='post.title'
              x-on:change="document.title = `ConneCTION - ${$el.value}`; $dispatch('editor-changed')">
          </div>
          <div class="control">
            <button class="button is-dark">Save</button>
          </div>
          <div class="control">
            @if ($post->published)
              <button class="button" type="button" @@click="show = true;">
                Update Metadata
              </button>
            @else
              <button class="button" type="button"
                @@click="show = true; $wire.set('post.published', true, true);">
                Publish
              </button>
            @endif
          </div>
        </div>
      </div>
    </x-hero>
    <main class="container is-fluid mt-5">
      <x-editor name="body" wire:model.lazy='body' />
    </main>
    <x-modal title="Set Post Metadata" show-var="show">
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
          @if ($this->post->published) @@click="show = false;" @else @@click="show = false; $wire.set('post.published', false, true);" @endif>
          Cancel
        </button>
        <button class="button is-primary" type="submit" @@click="show = false">
          @if ($this->post->published)
            Update Metadata
          @else
            Publish
          @endif
        </button>
      </x-slot>
    </x-modal>
  </form>
</div>
