@php
  use App\Enums\Standard;
@endphp

<span wire:ignore>
  <select @@turbolinks:before-cache.document='slimSelect.destroy' x-data="slimSelect('Standards...')" {{ $attributes }}
    name="standards" id="standards">
    @foreach (Standard::cases() as $standard)
      <option wire:key="{{ $standard }}" value="{{ $standard }}">{{ $standard }}</option>
    @endforeach
  </select>
</span>
