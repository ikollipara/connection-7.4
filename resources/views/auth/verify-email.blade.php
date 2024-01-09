<x-layout title="ConneCTION - Verify Email">
  <main class="container mt-5">
    <h1 class="title has-text-centered is-1">Verify Email</h1>
    <hr>
    <p class="subtitle" style="margin-inline: 25%;">
      Please check your email for a verification link. You cannot post or comment until you verify your email.
      This is to prevent spam, and to ensure that you are a real person.
      If you did not receive the email,
    </p>
    <form class="has-text-centered" action="{{ route('verification.send') }}" method="post">
      @csrf
      <button @@click="$el.classList.add('is-loading')" type="submit"
        class="button is-primary is-outlined">Click
        here</button>
    </form>
  </main>
</x-layout>
