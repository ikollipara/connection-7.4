<x-layout title="ConneCTION - Reset Password">
  <main x-data class="container mt-3">
    <form action="{{ route('password.update') }}" method="post">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <x-forms.password label="Password" name="password" x-ref="password" value="" />
      <ul style="list-style: circle; list-style-position:inside;" class="column is-fullwidth">
        <li x-bind:class="/^(?=.*[0-9])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one digit
        </li>
        <li x-bind:class="/^(?=.*[a-z])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one lowercase letter
        </li>
        <li x-bind:class="/^(?=.*[A-Z])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one uppercase letter
        </li>
        <li x-bind:class="/^(?=.*[@#$%^&-+=()])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
          Must contain at least one symbol (@#$%^&-+=())
        </li>
        <li x-bind:class="/.{12,}/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
          Must be at least 12 characters long
        </li>
      </ul>
      <x-forms.password label="Confirm Password" name="password_confirmation" />
      <field>
        <button class="button is-primary" type="submit">Reset Password</button>
      </field>
    </form>
  </main>
</x-layout>
