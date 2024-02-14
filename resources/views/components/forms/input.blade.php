<section class="field">
  <label for="{{ $name }}" class="label">{{ $label }}</label>
  @if ($attributes->wire('loading')->hasModifier('class'))
    <span class="control is-expanded" {{ $attributes->wire('loading') }} {{ $attributes->wire('target') }}>
      <input id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->except(['wire:loading', 'wire:target']) }}
        @error($name)
            class="input is-danger"
        @else
            class="input"
        @enderror>
    @else
      <span class="control is-expanded">
        <input id="{{ $name }}" name="{{ $name }}" {{ $attributes }}
          @error($name)
            class="input is-danger"
        @else
            class="input"
        @enderror>
      </span>
  @endif
  @error($name)
    <p class="help is-danger">{{ $message }}</p>
  @enderror
</section>
