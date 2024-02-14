<div>
  <main x-data="{ password: '' }" class="container is-fluid mt-3">
    <form wire:submit.prevent='submit'>
      <input type="hidden" name="token" value="{{ $this->token }}">
      <x-forms.input wire:model.defer='email' label='Email' name='email' type='email' />
      <x-forms.password label='Password' name='password' x-model='password' wire:model.defer='password' />
      <ul style="list-style: circle; list-style-position:inside;" class="column is-fullwidth">
        <li x-bind:class="/^(?=.*[0-9])/.test(password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one digit
        </li>
        <li x-bind:class="/^(?=.*[a-z])/.test(password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one lowercase letter
        </li>
        <li x-bind:class="/^(?=.*[A-Z])/.test(password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one uppercase letter
        </li>
        <li x-bind:class="/^(?=.*[@#$%^&-+=()])/.test(password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one symbol (@#$%^&-+=())
        </li>
        <li x-bind:class="/.{12,}/.test(password) ? 'has-text-success' : 'has-text-danger'">
          Must be at least 12 characters long
        </li>
      </ul>
      <x-forms.password label='Confirm Password' name='password_confirmation'
        wire:model.defer='password_confirmation' />
      <div class="field">
        <div class="control">
          <button wire:loading.class='is-loading' wire:target='submit' class="button is-primary" type="submit">Reset
            Password</button>
        </div>
      </div>
    </form>
  </main>
</div>
