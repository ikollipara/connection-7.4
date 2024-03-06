<main class="container is-fluid mt-5 columns is-multiline">
  <div class="column is-full">
    <section class="field has-addons">
      <span class="control is-expanded">
        <input id="query" name="query" wire:model.defer="query" placeholder="Search..."
          @error('query')
                class="input is-danger"
            @else
                class="input"
            @enderror>
      </span>
      @error('query')
        <p class="help is-danger">{{ $message }}</p>
      @enderror
      <div class="control">
        <button wire:target='search' wire:click='search' wire:loading.class="is-loading"
          class="button is-primary">Search</button>
      </div>
      <div class="control">
        <div class="select">
          <select wire:model.defer="type">
            <option value="">Both</option>
            <option value="post">Post</option>
            <option value="collection">Collection</option>
          </select>
        </div>
    </section>
  </div>
  <aside class="column is-one-quarter">
    <section class="is-flex is-flex-direction-column" style="gap: 0.5rem;">
      <h2 class="subtitle is-4">Advanced Search</h2>
      <p class="content is-medium has-text-grey">Total Results: {{ $this->results->count() }}</p>
      <x-forms.input wire:model.defer='likes_count' type="number" name="likes_count" min="0"
        label="Minimum Likes" />
      <x-forms.input wire:model.defer='views_count' type="number" name="views_count" min="0"
        label="Minimum Views" />
      <x-forms.standards wire:model.defer="standards" multiple />
      <x-forms.practices wire:model.defer="practices" multiple />
      <x-forms.grades wire:model.defer="grades" multiple />
      <x-forms.categories wire:model.defer="categories" multiple />
      <x-forms.audiences wire:model.defer="audiences" multiple />
      <x-forms.languages wire:model.defer="languages" multiple />
    </section>
  </aside>
  </div>
  <section class="column is-three-quarters">
    @if ($this->results->count() > 0)
      <table class="table is-fullwidth">
        <thead>
        </thead>
        <tbody>
          @foreach ($this->results as $result)
            <x-search.row :item="$result" />
          @endforeach
        </tbody>
      </table>
    @else
      <p class="content is-medium">No Results</p>
    @endif
  </section>

</main>
