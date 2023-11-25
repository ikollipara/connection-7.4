<x-layout title="{{ $collection->title }} Comments">
  <x-hero class="is-primary">
    <h1 class="title is-4">{{ $collection->title }} Comments</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    @livewire('comments', ['item' => $collection])
  </main>
</x-layout>
