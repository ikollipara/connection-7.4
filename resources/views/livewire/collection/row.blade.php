<tr
  @@click="window.location.href = '{{ route('collections.edit', ['uuid' => $this->post_collection->id]) }}'"
  style="cursor: pointer;">
  <td>
    @if ($this->post_collection->title)
      {{ $this->post_collection->title }}
    @else
      Unnamed Collection
    @endif
  </td>
  <td>
    {{ $this->post_collection->posts()->count() }}
  </td>
  <td>
    @if ($this->post_collection->created_at)
      {{ $this->post_collection->created_at->toFormattedDateString() }}
    @endif
  </td>
  <td>
    @if ($this->post_collection->updated_at)
      {{ $this->post_collection->updated_at->toFormattedDateString() }}
    @endif
  </td>
  <td>
    @if ($this->post_collection->published)
      <span class="icon-text">
        <span class="icon">
          <x-lucide-eye class="icon" width="30" height="30" fill="none" />
        </span>
        <span>{{ $this->post_collection->views }}</span>
      </span>
    @endif
  </td>
  <td>
    @if ($this->post_collection->published)
      <span class="icon-text">
        <span class="icon">
          <x-lucide-heart class="icon" width="30" height="30" fill="none" />
        </span>
        <span>{{ $this->post_collection->likes_count }}</span>
      </span>
    @endif
  </td>
  <td class="buttons mb-0">
    @if ($this->post_collection->published)
      <a @@click.stop
        href="{{ route('collections.show', ['post_collection' => $this->post_collection]) }}" class="button is-primary">
        <x-lucide-arrow-right class="icon" width="30" height="30" fill="none" />
      </a>
    @endif
    <a @@click.stop class="button is-primary is-outlined"
      href="{{ route('collections.edit', ['uuid' => $this->post_collection->id]) }}">
      <x-lucide-pencil class="icon" width="30" height="30" fill="none" />
    </a>
    @if ($this->post_collection->trashed())
      <button class="button is-danger" wire:click='restore' wire:target='restore' wire:loading.class='is-loading'>
        <x-lucide-archive-restore class="icon" width="30" height="30" fill="none" />
      </button>
    @else
      <button @@click.stop class="button is-danger" wire:click='archive' wire:target='archive'
        wire:loading.class='is-loading'>
        <x-lucide-archive class="icon" width="30" height="30" fill="none" />
      </button>
    @endif
  </td>
</tr>
