@props(['rule', 'model', 'success' => 'has-text-success', 'error' => 'has-text-danger'])

<li x-bind:class="/{{ $rule }}/.test({{ $model }}) ? '{{ $success }}' : '{{ $error }}'">
  {{ $slot }}
</li>
