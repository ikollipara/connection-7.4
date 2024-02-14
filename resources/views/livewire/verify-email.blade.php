<main class="container mt-5">
  <h1 class="title has-text-centered is-1">Verify Email</h1>
  <hr>
  <p class="subtitle" style="margin-inline: 25%">
    Please check your email for a verification link.
    You cannot post or comment until you verify your email.
    This is to prevent spam, and to ensure that you are a real person.
    If you did not receive the email,
  </p>
  <div class="level is-justify-content-center">
    <button wire:click='resend' wire:loading.class='is-loading' wire:loading.attr='disabled' wire:target='resend'
      class="button is-primary is-outlined">
      Click here
    </button>
  </div>
</main>
