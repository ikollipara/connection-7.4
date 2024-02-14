<div>
  <x-hero class="is-primary">
    <h1 class="title">Forgot Password</h1>
  </x-hero>
  <main class="container is-fluid imt-5">
    <form class="mt-5 mb-5" wire:submit.prevent='submit'>
      <x-forms.input label="Email" name="email" wire:model='email' />
      <div class="field">
        <div class="control">
          <button wire:loading.class='is-loading' wire:target='submit' class="button is-primary" type="submit">Send
            Password Reset Link
          </button>
        </div>
      </div>
    </form>
  </main>
</div>
