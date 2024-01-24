<x-layout title="conneCTION - My Settings">
  <x-hero class="is-primary">
    <div class="is-flex is-justify-content-space-between is-align-items-center">
      <h1 class="title is-3 mb-0">Settings</h1>
      @livewire('delete-account', ['user' => auth()->user()])
    </div>
  </x-hero>
  <main class="container is-fluid mt-5">
    @livewire('settings')
  </main>
</x-layout>
