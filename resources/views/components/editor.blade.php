@if ($attributes->wire('model')->value)
  <span x-data="{ body: @entangle($attributes->wire('model')) }">
    <article @@editor-saved.document="persistDeletedImages" wire:ignore class="content is-medium editor"
      {{ $attributes->except('wire:model') }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', JSON.parse(body))">
    </article>
  </span>
@else
  <span x-data="{ body: {{ $model }} }">
    <article @@editor-saved.document="persistDeletedImages" wire:ignore class="content is-medium editor"
      {{ $attributes }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', body)">
    </article>
  </span>
@endif
