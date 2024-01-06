@if ($attributes->wire('model')->value)
  <span x-data="{ body: @entangle($attributes->wire('model')) }">
    <article wire:ignore class="content is-medium" {{ $attributes }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', JSON.parse(body))">
    </article>
  </span>
@else
  <span x-data="{ body: {{ $model }} }">
    <article wire:ignore class="content is-medium" {{ $attributes }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', body)">
    </article>
  </span>
@endif
