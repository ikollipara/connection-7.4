<button type="button" wire:init='loadLikes' @class([
    'button',
    'mx-3',
    'is-loading' => $this->ready_to_load_likes === false,
    'is-primary' => $this->ready_to_load_likes,
    'icon-text' => $this->ready_to_load_likes,
]) wire:click='toggleLike' wire:target='toggleLike'
  wire:loading.class='is-loading'>
  @if ($this->ready_to_load_likes)
    @if ($this->liked)
      <x-lucide-heart class="icon" width="30" height="30" fill="white" />
    @else
      <x-lucide-heart class="icon" width="30" height="30" fill="none" />
    @endif
    <span>{{ $this->likes }}</span>
  @endif
</button>
