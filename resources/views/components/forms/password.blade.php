<section x-data="{ show: false }" class="field">
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    <div class="field has-addons">
        <span class="control is-expanded">
            <input id="{{ $name }}" name="{{ $name }}" {{ $attributes }}
                x-bind:type="show ? 'text' : 'password'" class="input @error($name) is-danger @enderror">
        </span>
        <div class="control">
            <button type="button" class="button" x-on:click='show = !show'>
                <x-lucide-eye width="24" height="24" x-show="!show" />
                <x-lucide-eye-off width="24" height="24" x-show="show" />
            </button>
        </div>
    </div>
    @error($name)
        <p class="help is-danger">{{ $message }}</p>
    @enderror
</section>
