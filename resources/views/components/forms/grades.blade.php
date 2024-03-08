@php
  use App\Enums\Grade;
@endphp

<span wire:ignore>
  <select x-data="slimSelect('Grades...')" {{ $attributes }} name="grades" id="grades">
    @foreach (Grade::asPairs() as $grade)
      <option wire:key="{{ $grade[0] }}" value="{{ $grade[0] }}">{{ $grade[1] }}</option>
    @endforeach
  </select>
</span>
