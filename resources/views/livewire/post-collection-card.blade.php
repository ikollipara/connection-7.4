<article id="collection-{{ $this->collection->id }}" class="mt-3 mx-5">
  <div class="level">
    <div class="level-start">
      <p class="title is-4">{{ $this->collection->title ?? 'Unamed Collection' }}</p>
    </div>
    <div class="level-end" style="display: inline-flex; gap: 1rem;">
      <a href="{{ URL::route('collections.edit', ['post_collection' => $this->collection]) }}"
        class="level-item button is-primary is-outlined">Edit</a>
      @if ($this->collection->trashed())
        <button wire:click="restore" type="button" class="button is-primary">Restore</button>
      @else
        <button wire:click="archive" type="button" class="button is-primary">Archive</button>
      @endif
    </div>
  </div>
  <table class="table is-fullwidth">
    <tbody>
      <tr class="content is-italic">
        <td>Last Updated</td>
        <td>{{ $this->collection->updated_at->toFormattedDateString() }}</td>
      </tr>
      @if ($this->collection->published)
        <tr class="content is-italic">
          <td>Views</td>
          <td>{{ $this->collection->views }}</td>
        </tr>
        <tr>
          <td></td>
          <td>
            <a href="{{ URL::route('collections.show', ['post_collection' => $this->collection]) }}">Visit</a>
          </td>
        </tr>
      @endif
    </tbody>
  </table>
  @push('scripts')
    <script>
      document.addEventListener('livewire:load', function() {
        Livewire.on('collectionArchived', (collectionId) => {
          if (collectionId != "{{ $this->collection->id }}") return
          document.querySelector('#collection-{{ $this->collection->id }}').classList.add(
            'animate__animated',
            'animate__fadeOut')
          window.setTimeout(() => {
            document.querySelector('#collection-{{ $this->collection->id }}').remove()
          }, 1000)
        })
        Livewire.on('collectionRestored', (collectionId) => {
          if (collectionId != "{{ $this->collection->id }}") return
          document.querySelector('#collection-{{ $this->collection->id }}').classList.add(
            'animate__animated',
            'animate__fadeOut')
          window.setTimeout(() => {
            document.querySelector('#collection-{{ $this->collection->id }}').remove()
          }, 1000)
        })

      })
    </script>
  @endpush
</article>
