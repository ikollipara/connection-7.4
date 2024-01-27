<form wire:submit.prevent="save" method="post" class="columns">
  <div class="column">
    <div class="image mb-3" style="max-width: 50%; margin-inline:auto">
      <img
        @if ($this->avatar) src="{{ $this->avatar->temporaryUrl() }}"
                @else
                src="{{ auth()->user()->avatar_url() }}" @endif
        alt="Profile Picture">
    </div>
    <div x-data="{ filename: 'No File Uploaded' }" class="control">
      <div class="file has-name is-fullwidth">
        <label class="file-label">
          <input type="file" @@change="filename = $event.target.files[0].name" wire:model="avatar"
            class="file-input" accept="image/*">
          <span class="file-cta">
            <span class="file-icon">
              <x-lucide-upload width="50" height="50" />
            </span>
            <span class="file-label">
              Choose a file...
            </span>
          </span>
          <span class="file-name" x-text="filename">No File Uploaded</span>
        </label>
      </div>
    </div>
    <x-editor wire:model="bio" name="bio" />
  </div>
  <div class="column is-half">
    <x-forms.input wire:model="first_name" label="First Name" name="first_name" />
    <x-forms.input wire:model="last_name" label="Last Name" name="last_name" />
    <x-forms.input wire:model="email" label="Email" name="email" type="email" />
    <x-forms.input wire:model="school" label="School" name="school" />
    <x-forms.input wire:model="subject" label="Subject" name="subject" />
    <x-forms.grades multiple wire:model="grades" label="grades" name="grades" />
    <label class="checkbox">
      <input type="checkbox" wire:model='no_comment_notifications'>
      I do not want to recieve comment notifications
    </label>
    <div class="buttons mt-5">
      <button type="submit" class="button is-primary">Update</button>
      <button wire:click="reset_form" type="button" class="button is-danger is-outlined">Cancel</button>
    </div>
  </div>
</form>
