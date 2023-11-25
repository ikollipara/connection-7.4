<section class="field">
  <div class="control">
    <label for="{{ $name }}" class="label">{{ $label }}</label>
  </div>
  <div x-data="{ filename: '' }" class="control">
    <div class="file has-name is-boxed">
      <label class="file-label">
        <input {{ $attributes }} x-on:change="filename = $event.target.files[0].name" name="{{ $name }}"
          id="" class="file-input" type="file" accept="image/*">
        <span class="file-cta">
          <span class="file-icon">
            <x-lucide-upload width="50" height="50" />
          </span>
          <span class="file-label">
            Choose a file...
          </span>
        </span>
        <span @if ($showText) hidden @endif class="file-name" x-text="filename"></span>
      </label>
    </div>

  </div>
</section>
