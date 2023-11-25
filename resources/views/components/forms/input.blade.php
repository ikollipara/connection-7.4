<section class="field">
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    <span class="control is-expanded">
        <input id="{{ $name }}" name="{{ $name }}" {{ $attributes }}
            @error($name)
            class="input is-danger"
        @else
            class="input"
        @enderror>
    </span>
    @error($name)
        <p class="help is-danger">{{ $message }}</p>
    @enderror
</section>
