<x-layout title="{{ $post->title }} Comments">
  <x-hero class="is-primary">
    <h1 class="title is-4">{{ $post->title }} Comments</h1>
  </x-hero>
  <main class="container is-fluid mt-5">
    @livewire('comments', ['item' => $post])
  </main>
</x-layout>
