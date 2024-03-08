<div>
  <x-hero class="is-primary">
    <h1 class="title">{{ Str::of($this->status)->title() }} Collections</h1>
    <x-forms.input wire:target='search' wire:loading.class='is-loading' label="" placeholder="Filter..." name="Filter"
      wire:model="search" />
    @if ($this->status == 'archived')
      <p class="content">
        Archived collections are similar to unlisted videos, if someone has the link they can access. But the video is
        unsearchable.
      </p>
    @endif
  </x-hero>
  <main wire:init='loadCollections' class="container">
    @if ($this->ready_to_load_collections === false)
      <span style="margin-block: 5em;" class="loader"></span>
    @else
      <table class="table is-fullwidth is-hoverable">
        <thead>
          <tr>
            <th>Title</th>
            <th>Number of Posts</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Views</th>
            <th>Likes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($this->postCollections as $post_collection)
            @livewire('collection.row', ['post_collection' => $post_collection], key($post_collection->id))
          @endforeach
        </tbody>
      </table>
      {{ $this->postCollections->links('pagination') }}
    @endif
  </main>
</div>
