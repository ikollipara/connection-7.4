<div>
  <x-hero class="is-primary">
    <h1 class="title">Login</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    <form wire:submit.prevent='login' class="mt-5 mb-5">
      <x-forms.input label="Email" name="email" wire:model.debounce.500ms='email' />
      <x-forms.password label="Password" name="password" wire:model.debounce.500ms='password' />
      <div class="field">
        <div class="control">
          <label class="checkbox">
            <input wire:model.defer='remember_me' type="checkbox">
            Remember me
          </label>
        </div>
      </div>
      <div class="field">
        <div class="control">
          <button wire:loading.class='is-loading' wire:target='login' class="button is-primary" type="submit">
            Login
          </button>
        </div>
    </form>
    <a href="{{ route('password.request') }}" class="link">Forgot Password</a>
  </main>
  @push('meta')
    <meta name="turbolinks-visit-control" content="reload">
  @endpush
</div>
