@php
  use App\Enums\Category;
@endphp

<span wire:ignore>
  <select @@turbolinks:before-cache.document='slimSelect.destroy' x-data="slimSelect('Categories...')"
    x-modelable="selected" {{ $attributes }} name="category" id="category">
    @foreach (Category::cases() as $category)
      <option wire:key="{{ $category }}" value="{{ $category }}">{{ Str::of($category)->title() }}
      </option>
    @endforeach
  </select>
</span>
