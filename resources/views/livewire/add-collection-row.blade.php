<tr>
  <td>
    @if ($this->has_post)
      <button type="button" wire:click="remove" wire:loading.class="is-loading" class="button is-danger is-outlined">
        <x-lucide-minus class="icon" width="30" height="30" fill="none" />
      </button>
    @else
      <button type="button" wire:click="add" wire:loading.class="is-loading" class="button is-success is-outlined">
        <x-lucide-plus class="icon" width="30" height="30" fill="none" />
      </button>
    @endif
  </td>
  <td>
    <p class="subtitle is-4">{{ $this->collection->title }}</p>
  </td>
</tr>
