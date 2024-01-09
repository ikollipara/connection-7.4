<x-layout title="ConneCTION - Forgot Password">
  <x-hero class="is-primary">
    <h1 class="title">Forgot Password</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    <form class="mt-5 mb-5" method="post" action="{{ route('password.email') }}">
      @csrf
      @if (session('status'))
        <div class="notification is-danger">
          {{ session('status') }}
        </div>
      @endif
      <x-forms.input label="Email" name="email" />
      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Send Password Reset Link</button>
        </div>
      </div>
    </form>
  </main>
</x-layout>
