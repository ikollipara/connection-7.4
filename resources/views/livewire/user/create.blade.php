<div>
  <x-hero class="is-primary">
    <h1 class="title">Sign Up</h1>
  </x-hero>
  <main x-data="{ currentStep: 0 }" class="container is-fluid mt-5">
    <form wire:submit.prevent='save' class="mt-5 mb-5" enctype="multipart/form-data" method="post">
      <x-forms.step step="0" current-step="currentStep">
        <h2 class="subtitle is-3 has-text-centered">Personal Information</h2>
        <x-forms.input label="First Name" name="first_name" wire:model.debounce.200ms="user.first_name" />
        <x-forms.input label="Last Name" name="last_name" wire:model.debounce.200ms="user.last_name" />
        <x-forms.input label="Email" name="email" type="email" wire:model.debounce.200ms="user.email" />
      </x-forms.step>
      <x-forms.step step="1" current-step="currentStep">
        <h2 class="subtitle is-3 has-text-centered">Teacher Information</h2>
        <div class="field">
          <label for="grades" class="label">Grades</label>
          <div class="field has-addons">
            <div class="control is-expanded">
              <x-forms.grades wire:model="user.grades" multiple />
            </div>
          </div>
        </div>
        <label class="checkbox">
          <input type="checkbox" wire:model='user.is_preservice'>
          I am a preservice teacher
        </label>
        @if ($this->user->is_preservice === false)
          <x-forms.input label="School" name="school" wire:model.debounce.200ms="user.school" />
          <x-forms.input label="Years of Experience" name="years_of_experience" type="number"
            wire:model.debounce.200ms="user.years_of_experience" />
        @endif
        <x-forms.input label="Subject" name="subject" wire:model.debounce.200ms="user.subject" />
      </x-forms.step>
      <x-forms.step step="2" current-step="currentStep">
        <h2 class="subtitle is-3 has-text-centered">Your Profile Information</h2>
        <div class="level is-justify-content-center">
          <x-forms.image label="Avatar" name="avatar" wire:model.debounce.200ms="avatar" />
        </div>
        <x-editor name="bio" wire:model="user.bio" cannot-upload />
      </x-forms.step>
      <x-forms.step step="3" current-step="currentStep">
        <h2 class="subtitle is-3 has-text-centered">Your Password</h2>
        <x-forms.password label="Password" name="password" wire:model.debounce.200ms="password" />
        <ul style="list-style: circle; list-style-position: inside;" class="column is-fullwidth">
          <x-forms.rule rule="^(?=.*[0-9])" model="$wire.password">
            Must contain at least one digit
          </x-forms.rule>
          <x-forms.rule rule="^(?=.*[a-z])" model="$wire.password">
            Must contain at least one lowercase letter
          </x-forms.rule>
          <x-forms.rule rule="^(?=.*[A-Z])" model="$wire.password">
            Must contain at least one uppercase letter
          </x-forms.rule>
          <x-forms.rule rule="^(?=.*[@#$%^&-+=()])" model="$wire.password">
            Must contain at least one special character (e.g. @#$%^&-+=())
          </x-forms.rule>
          <x-forms.rule rule=".{12,}" model="$wire.password">
            Must be at least 12 characters long
          </x-forms.rule>
        </ul>
        <x-forms.password label="Confirm Password" name="password_confirmation"
          wire:model.debounce.200ms="password_confirmation" />
      </x-forms.step>
      <x-forms.step x-data='{checked: true}' step="4" current-step="currentStep" is-final>
        <h2 class="subtitle is-3 has-text-centered">conneCTION Research Study</h2>
        <x-research.consent-form />
        <hr>
        <div class="field">
          <label class="checkbox">
            <input type="checkbox" x-model='checked'>
            I want to participate in the conneCTION Research Study
          </label>
        </div>
        <div class="field">
          <label class="checkbox" x-bind:class="{ 'is-hidden': !checked }">
            <input type="checkbox" wire:model='above_19'>
            I am 19 years or older
          </label>
        </div>
        @if ($this->above_19)
          <x-forms.input label="Please enter your full name to consent." wire:model.debounce.200ms="full_name"
            name="full_name" />
        @endif
      </x-forms.step>
    </form>
  </main>
</div>
