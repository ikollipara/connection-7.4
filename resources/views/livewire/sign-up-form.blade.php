<form x-on:submit="currentStep = 0" class="mt-5 mb-5" x-data="{ currentStep: 0 }" enctype="multipart/form-data"
    wire:submit.prevent="save">
    @if (session('status'))
        <div class="notification is-danger">
            {{ session('status') }}
        </div>
    @endif
    <section x-show="currentStep == 0">
        <h2 class="subtitle is-3 has-text-centered">Personal Information</h2>
        <x-forms.input label="First Name" name="first_name" wire:model.debounce.200ms="first_name" />
        <x-forms.input label="Last Name" name="last_name" wire:model.debounce.200ms="last_name" />
        <x-forms.input label="Email" name="email" type="email" wire:model.debounce.200ms="email" />
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button type="button" x-on:click="currentStep++" class="button is-primary">
                    Next
                </button>
            </div>
        </div>
    </section>
    <section x-show="currentStep == 1">
        <h2 class="subtitle is-3 has-text-centered">Teacher Information</h2>
        <div class="field">
            <label for="grades" class="label">Grades</label>
            <div class="field has-addons">
                <div class="control is-expanded">
                    <x-forms.grades wire:model="grades" multiple />
                </div>
            </div>
        </div>
        <x-forms.input label="School" name="school" wire:model.debounce.200ms="school" />
        <x-forms.input label="Subject" name="subject" wire:model.debounce.200ms="subject" />
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button type="button" x-on:click="currentStep--" class="button is-primary is-outlined">
                    Back
                </button>
                <button type="button" x-on:click="currentStep++" class="button is-primary">
                    Next
                </button>
            </div>
        </div>
    </section>
    <section x-show="currentStep == 2">
        <h2 class="subtitle is-3 has-text-centered">Your Profile Information</h2>
        <x-forms.image label="Avatar" name="avatar" wire:model.debounce.200ms="avatar" />
        <x-editor name="bio" model="bio" cannot-upload />
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button type="button" x-on:click="currentStep--" class="button is-primary is-outlined">
                    Back
                </button>
                <button type="button" x-on:click="currentStep++" class="button is-primary">
                    Next
                </button>
            </div>
        </div>
    </section>
    <section x-show="currentStep == 3">
        <h2 class="subtitle is-3 has-text-centered">Your Password</h2>
        <x-forms.password label="Password" name="password" wire:model.debounce.200ms="password" />
        <ul style="list-style: circle; list-style-position:inside;" class="column is-fullwidth">
            <li x-bind:class="/^(?=.*[0-9])/.test($wire.password) ? 'has-text-success' : 'has-text-danger'">
                Must contain at least one digit
            </li>
            <li x-bind:class="/^(?=.*[a-z])/.test($wire.password) ? 'has-text-success' : 'has-text-danger'">
                Must contain at least one lowercase letter
            </li>
            <li x-bind:class="/^(?=.*[A-Z])/.test($wire.password) ? 'has-text-success' : 'has-text-danger'">
                Must contain at least one uppercase letter

            </li>
            <li x-bind:class="/^(?=.*[@#$%^&-+=()])/.test($wire.password) ? 'has-text-success' : 'has-text-danger'">
                Must contain at least one symbol (@#$%^&-+=())
            </li>
            <li x-bind:class="/.{12,}/.test($wire.password) ? 'has-text-success' : 'has-text-danger'">
                Must be at least 12 characters long
            </li>
        </ul>
        <x-forms.password label="Confirm Password" name="password_confirmation"
            wire:model.debounce.200ms="password_confirmation" />
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <button type="button" x-on:click="currentStep--" class="button is-primary is-outlined">
                    Back
                </button>
                <button type="submit" class="button is-primary">
                    Sign Up
                </button>
            </div>
        </div>
    </section>
</form>
