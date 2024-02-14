<tr @@click="window.location.href = '{{ route('posts.edit', ['uuid' => $this->post->id]) }}'"
  style="cursor: pointer;">
  <td>
    @if ($this->post->title)
      {{ $this->post->title }}
    @else
      Unnamed Post
    @endif
  </td>
  <td>
    @if ($this->post->created_at)
      {{ $this->post->created_at->toFormattedDateString() }}
    @endif
  </td>
  <td>
    @if ($this->post->updated_at)
      {{ $this->post->updated_at->toFormattedDateString() }}
    @endif
  </td>
  <td>
    @if ($this->post->published)
      <span class="icon-text">
        <span class="icon">
          <x-lucide-eye class="icon" width="30" height="30" fill="none" />
        </span>
        <span>{{ $this->post->views }}</span>
      </span>
    @endif
  </td>
  <td>
    @if ($this->post->published)
      <span class="icon-text">
        <span class="icon">
          <x-lucide-heart class="icon" width="30" height="30" fill="none" />
        </span>
        <span>{{ $this->post->likes_count }}</span>
      </span>
    @endif
  </td>
  <td class="buttons mb-0">
    @if ($this->post->published)
      <a @@click.stop href="{{ route('posts.show', ['post' => $this->post]) }}"
        class="button is-primary">
        <x-lucide-arrow-right class="icon" width="30" height="30" fill="none" />
      </a>
    @endif
    <a @@click.stop class="button is-primary is-outlined"
      href="{{ route('posts.edit', ['uuid' => $this->post->id]) }}">
      <x-lucide-pencil class="icon" width="30" height="30" fill="none" />
    </a>
    @if ($this->post->trashed())
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
