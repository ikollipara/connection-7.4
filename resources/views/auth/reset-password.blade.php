<x-layout title="ConneCTION - Reset Password">
  <form action="{{ route('password.update') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <x-forms.password label="Password" name="password" x-ref="password" />
    <ul style="list-style: circle; list-style-position:inside;" class="column is-fullwidth">
      <li ::class="/^(?=.*[0-9])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
        Must contain at least one digit
      </li>
      <li ::class="/^(?=.*[a-z])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
        Must contain at least one lowercase letter
      </li>
      <li ::class="/^(?=.*[A-Z])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
        Must contain at least one uppercase letter

      </li>
      <li ::class="/^(?=.*[@#$%^&-+=()])/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
        Must contain at least one symbol (@#$%^&-+=())
      </li>
      <li ::class="/.{12,}/.test($refs.password) ? 'has-text-success' : 'has-text-danger'">
        Must be at least 12 characters long
      </li>
    </ul>
    <x-forms.password label="Confirm Password" name="password_confirmation" />
    <field>
      <button type="submit">Reset Password</button>
    </field>
  </form>
</x-layout>
