<div>
  @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <a class="pagination-previous is-disabled">
          {!! __('pagination.previous') !!}
        </a>
      @else
        <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="pagination-previous">
          {!! __('pagination.previous') !!}
        </button>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="pagination-next">
          {!! __('pagination.next') !!}
        </a>
      @else
        <a class="pagination-next is-disabled">
          {!! __('pagination.next') !!}
        </a>
      @endif
    </nav>
  @endif
</div>
