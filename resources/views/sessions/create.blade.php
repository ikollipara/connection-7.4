<x-layout title="conneCTION - Login">
  <x-hero class="is-primary">
    <h1 class="title">Login</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    <form class="mt-5 mb-5" method="post" action="{{ route('login.store') }}">
      @csrf
      @if (session('status'))
        <div class="notification is-danger">
          {{ session('status') }}
        </div>
      @endif
      <x-forms.input label="Email" name="email" />
      <x-forms.password label="Password" name="password" />
      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Login</button>
        </div>
      </div>
    </form>
    <a href="{{ route('password.request') }}" class="link">Forgot Password</a>
  </main>
</x-layout>
