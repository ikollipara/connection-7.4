<x-layout title="conneCTION - My Settings">
  <x-hero class="is-primary">
    <h1 class="title is-3">Settings</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    @livewire('delete-account', ['user' => auth()->user()])
    @livewire('settings')
  </main>
</x-layout>
