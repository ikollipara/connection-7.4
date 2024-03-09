<div>
  <x-hero class="is-primary">
    <div class="is-flex" style="gap: 1rem;">
      <figure class="image is-128x128 mt-auto mb-auto">
        <img src="{{ $this->user->avatar() }}" alt="">
      </figure>
      <div class="is-flex is-flex-direction-column">
        <h1 class="title is-1">{{ $this->user->full_name() }}</h1>
        <div class="is-flex is-justify-content-start is-align-items-center" style="gap: 1em;">
          <a href="" class="is-link">{{ $this->user->followers_count }} Followers</a>
          <a href="" class="is-link">{{ $this->user->following_count }} Following</a>
        </div>
        <p class="is-italic content">
          {{ $this->user->subject }} Teacher at
          {{ $this->user->school }}
        </p>
      </div>
    </div>
    <x-forms.input name="search" placeholder="Search..." label="" wire:model.debounce.300ms="search" />
  </x-hero>
  <main wire:init='loadCollections' class="container is-fluid mt-3">
    @if ($this->ready_to_load_collections === false)
      <span style="margin-block: 5em;" class="loader"></span>
    @else
      <table class="table is-fullwidth">
        <thead></thead>
        <tbody>
          @foreach ($this->collections as $collection)
            <x-search.row :item="$collection" :show-user="false" />
          @endforeach
        </tbody>
      </table>
      {{ $this->collections->links('pagination') }}
    @endif
  </main>
</div>
