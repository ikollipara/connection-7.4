<button wire:loading.class="is-loading"
    @if ($this->liked) wire:click="unlike"
    @else
        wire:click="like" @endif type="button"
    class="button is-primary icon-text mx-3">
    @if ($this->liked)
        <x-lucide-heart class="icon" width="30" height="30" fill="white" />
    @else
        <x-lucide-heart class="icon" width="30" height="30" fill="none" />
    @endif
    <span>{{ $this->likes }}</span>
</button>
