@php
  use App\Enums\Practice;
@endphp

<span wire:ignore>
  <select @@turbolinks:before-cache.document='slimSelect.destroy' x-data="slimSelect('Practices...')"
    x-modelable="selected" {{ $attributes }} name="practice" id="practice">
    @foreach (Practice::cases() as $practice)
      <option wire:key="{{ $practice }}" value="{{ $practice }}">{{ $practice }}</option>
    @endforeach
  </select>
</span>
