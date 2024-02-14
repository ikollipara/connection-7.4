@props(['title', 'showVar' => 'show'])
<span x-data="{ {{ $showVar }}: false }">
  <button type="button" @@click="{{ $showVar }} = true"
    {{ $attributes->merge(['class' => 'button is-primary']) }}>
    <x-lucide-help-circle class="icon" />
  </button>
  <x-modal show-var="{{ $showVar }}" title="{{ $title }}">
    {{ $slot }}
  </x-modal>
</span>
